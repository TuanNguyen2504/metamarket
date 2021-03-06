const { DEFAULT, SVC_NAME } = require('../../../utils/constants');
const { mongoosePaginate } = require('../../../utils/mongoose-paginate');
const { Product, ProductDetail } = require('../product.db');
const { MoleculerError } = require('moleculer').Errors;
const ObjectID = require('mongoose').Types.ObjectId;

module.exports = {
	getProductWithCatalog: {
		cache: false,

		params: {
			catalogId: [
				{
					type: 'string',
					length: 24,
				},
				{
					type: 'objectID',
					ObjectID,
				},
			],
			page: {
				type: 'string',
				numeric: true,
				min: '1',
				default: '1',
			},
			pageSize: {
				type: 'string',
				numeric: true,
				min: '1',
				default: DEFAULT.PAGE_SIZE.toString(),
			},
			select: {
				type: 'string',
				optional: true,
				default: '',
			},
			sort: {
				type: 'string',
				optional: true,
				default: '',
			},
		},

		async handler(ctx) {
			let { catalogId, page, pageSize, select, sort } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);

			try {
				const productDocs = await mongoosePaginate(
					Product,
					{ catalogId },
					{ pageSize, page },
					{ select, sort },
				);
				return productDocs;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getProductWithCategory: {
		cache: false,

		params: {
			catalogId: [
				{
					type: 'string',
					length: 24,
				},
				{
					type: 'objectID',
					ObjectID,
				},
			],
			categoryId: [
				{
					type: 'string',
					numeric: true,
				},
				{
					type: 'number',
				},
			],
			page: {
				type: 'string',
				numeric: true,
				min: '1',
				default: '1',
			},
			pageSize: {
				type: 'string',
				numeric: true,
				min: '1',
				default: DEFAULT.PAGE_SIZE.toString(),
			},
			select: {
				type: 'string',
				optional: true,
				default: '',
			},
			sort: {
				type: 'string',
				optional: true,
				default: '',
			},
		},

		async handler(ctx) {
			let { catalogId, categoryId, page, pageSize, select, sort } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);

			try {
				const productDocs = await mongoosePaginate(
					Product,
					{ catalogId, categoryId },
					{ pageSize, page },
					{ select, sort },
				);
				return productDocs;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getBasicProductInfoById: {
		cache: false,
		params: {
			productId: {
				type: 'string',
				length: 24,
			},
		},

		async handler(ctx) {
			try {
				const { productId } = ctx.params;
				const product = await Product.findById(productId).populate({
					path: 'catalogId',
					select: '-categories',
				});
				return product;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getProductDetailById: {
		cache: false,
		params: {
			productId: {
				type: 'string',
				length: 24,
			},
		},
		async handler(ctx) {
			try {
				const { productId } = ctx.params;
				const productDetail = await ProductDetail.findOne({ productId });
				return productDetail;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getProductByShopId: {
		cache: false,
		params: {
			shopId: [{ type: 'string', numeric: true }, { type: 'number' }],
			pageSize: [
				{ type: 'number', default: DEFAULT.PAGE_SIZE },
				{
					type: 'string',
					numeric: true,
					default: DEFAULT.PAGE_SIZE.toString(),
				},
			],
			page: [
				{ type: 'number', default: 1 },
				{ type: 'string', numeric: true, default: '1' },
			],
			select: {
				type: 'string',
				optional: true,
				default: '',
			},
			sort: { type: 'string', optional: true, default: 'createdAt' },
			query: { type: 'string', optional: true, default: '{}' },
		},
		async handler(ctx) {
			try {
				let {
					pageSize,
					select,
					shopId,
					page,
					sort = 'createdAt',
					query = '{}',
				} = ctx.params;
				[page, pageSize, shopId] = [page, pageSize, shopId].map(Number);

				let where = { shopId };
				if (query) {
					const queryObj = JSON.parse(query);
					where = { ...where, ...queryObj };
				}

				const products = await mongoosePaginate(
					Product,
					{ ...where },
					{ page, pageSize },
					{ select, sort },
				);

				return products;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	searchProduct: {
		cache: false,
		params: {
			keyword: {
				type: 'string',
			},
			page: {
				type: 'string',
				numeric: true,
				min: '1',
				default: '1',
			},
			pageSize: {
				type: 'string',
				numeric: true,
				min: '1',
				default: DEFAULT.PAGE_SIZE.toString(),
			},
			sort: {
				type: 'string',
				optional: true,
				default: '',
			},
			select: {
				type: 'string',
				optional: true,
				default: '_id name price unit stock code avt discount',
			},
		},
		async handler(ctx) {
			let { keyword, page, pageSize, select, sort } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);
			keyword = decodeURIComponent(escape(keyword));

			try {
				const productDocs = await mongoosePaginate(
					Product,
					{
						$or: [
							{ name: { $regex: keyword, $options: 'i' } },
							{ code: { $regex: keyword, $options: 'i' } },
						],
					},
					{ page, pageSize },
					{ select, sort },
				);
				return productDocs;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	postAddProduct: {
		cache: false,
		params: {
			catalogId: 'string',
			categoryId: [
				{ type: 'number', min: 0 },
				{ type: 'string', numeric: true },
			],
			shopId: [
				{ type: 'number', min: 0 },
				{ type: 'string', numeric: true },
			],
			name: 'string',
			price: { type: 'number', min: 0 },
			code: 'string',
			stock: { type: 'number', min: 0 },
			discount: { type: 'number', min: 0, max: 100 },
			unit: 'string',
			avt: 'string',
			mfg: [{ type: 'string' }, { type: 'date' }],
			exp: [{ type: 'string' }, { type: 'date' }],

			origin: 'string',
			brand: 'string',
			desc: { type: 'string', optional: true, default: '' },
			photos: {
				type: 'array',
				items: 'string',
				default: [],
			},
		},
		async handler(ctx) {
			try {
				const {
					catalogId,
					categoryId,
					shopId,
					name,
					price,
					code,
					stock,
					discount,
					unit,
					avt,
					mfg,
					exp,
					origin,
					brand,
					desc = '',
					infos = [],
					photos = [],
				} = ctx.params;

				const product = await Product.create({
					catalogId,
					categoryId,
					shopId,
					name,
					price,
					code,
					stock,
					discount,
					unit,
					avt,
					mfg: new Date(mfg),
					exp: new Date(exp),
				});

				if (product) {
					const productDetail = await ProductDetail.create({
						productId: product._id,
						origin,
						brand,
						desc,
						infos,
						photos,
					});

					if (productDetail) {
						ctx.emit(`${SVC_NAME.PRODUCT}.createProduct`);
						return true;
					} else {
						Product.deleteOne({ _id: product._id });
					}
				}

				return false;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getReviewSummaryById: {
		cache: false,
		params: {
			productId: 'string',
		},
		async handler(ctx) {
			try {
				const product = Product.findById(ctx.params.productId).select(
					'reviewTotal rateAvg',
				);
				return product;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	putUpdateProductById: {
		cache: false,
		params: {
			productId: 'string',
			updateFields: 'any',
		},
		async handler(ctx) {
			try {
				if (!ctx.params.updateFields) {
					throw new Error('Invalid params');
				}
				const updateRes = await Product.updateOne(
					{ _id: ctx.params.productId },
					{ $set: { ...ctx.params.updateFields } },
				);
				if (updateRes) {
					return true;
				}
				return false;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	putUpdateDetailByProductId: {
		cache: false,
		params: {
			productId: 'string',
			updateFields: 'any',
		},
		async handler(ctx) {
			try {
				if (!ctx.params.updateFields) {
					throw new Error('Invalid params');
				}
				const updateRes = await ProductDetail.updateOne(
					{ productId: ctx.params.productId },
					{ $set: { ...ctx.params.updateFields } },
				);
				if (updateRes) {
					return true;
				}
				return false;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getShopByProductId: {
		cache: false,
		params: {
			productId: 'string',
		},
		async handler(ctx) {
			try {
				const product = await Product.findById(ctx.params.productId);
				if (product) {
					return product.shopId;
				}
				return -1;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getCountProductByShop: {
		cache: false,
		params: {
			shopId: ['number', { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			const { shopId } = ctx.params;
			try {
				const count = await Product.countDocuments({ shopId });
				return count;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	putDecreaseProductStockById: {
		params: {
			productId: 'string',
			quantity: 'number',
		},
		async handler(ctx) {
			try {
				await Product.findOneAndUpdate(
					{ _id: ctx.params.productId },
					{ $inc: { stock: -1 * Number(ctx.params.quantity) } },
				);
				return true;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	putIncreasePurchaseTotalById: {
		params: {
			productId: 'string',
			quantity: 'number',
		},
		async handler(ctx) {
			try {
				await Product.findOneAndUpdate(
					{ _id: ctx.params.productId },
					{ $inc: { purchaseTotal: 1 * Number(ctx.params.quantity) } },
				);
				return true;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	putShopUpdateProductById: {
		cache: false,
		params: {
			catalogId: 'string',
			categoryId: [
				{ type: 'number', min: 0 },
				{ type: 'string', numeric: true },
			],
			productId: 'string',
			code: 'string',
			name: 'string',
			price: { type: 'number', min: 0 },
			stock: { type: 'number', min: 0 },
			discount: { type: 'number', min: 0, max: 100 },
			unit: 'string',
			avt: 'string',
			origin: 'string',
			brand: 'string',
			currentPhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			removePhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			removeThumbPhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			addPhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			productPhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			desc: { type: 'string', optional: true, default: '' },
		},
		async handler(ctx) {
			const {
				catalogId,
				categoryId,
				productId,
				code,
				name,
				price,
				stock,
				discount,
				unit,
				avt,
				origin,
				brand,
				currentPhotos,
				removePhotos,
				removeThumbPhotos,
				addPhotos,
				productPhotos,
				desc,
			} = ctx.params;
			try {
				await ctx.call(`${SVC_NAME.PRODUCT}.putUpdateProductById`, {
					productId: productId,
					updateFields: {
						catalogId: catalogId,
						categoryId: categoryId,
						name: name,
						price: price,
						stock: stock,
						discount: discount,
						unit: unit,
					},
				});
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	putShopUpdateDetailByProductId: {
		cache: false,
		params: {
			catalogId: 'string',
			categoryId: [
				{ type: 'number', min: 0 },
				{ type: 'string', numeric: true },
			],
			productId: 'string',
			code: 'string',
			name: 'string',
			price: { type: 'number', min: 0 },
			stock: { type: 'number', min: 0 },
			discount: { type: 'number', min: 0, max: 100 },
			unit: 'string',
			avt: 'string',
			origin: 'string',
			brand: 'string',
			currentPhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			removePhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			removeThumbPhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			addPhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			productPhotos: {
				type: 'array',
				items: 'string',
				default: [],
			},
			desc: { type: 'string', optional: true, default: '' },
		},
		async handler(ctx) {
			const {
				catalogId,
				categoryId,
				productId,
				code,
				name,
				price,
				stock,
				discount,
				unit,
				avt,
				origin,
				brand,
				currentPhotos,
				removePhotos,
				removeThumbPhotos,
				addPhotos,
				productPhotos,
				desc,
			} = ctx.params;
			try {
				await ctx.call(`${SVC_NAME.PRODUCT}.putUpdateDetailByProductId`, {
					productId: productId,
					updateFields: {
						photos: productPhotos,
						origin: origin,
						brand: brand,
						desc: desc,
					},
				});
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
