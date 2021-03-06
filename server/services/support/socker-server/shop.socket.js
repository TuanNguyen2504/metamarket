const { Shop } = require('../../user/user.db');
const { ShopChat } = require('../support.db');
const { shopIO } = require('./socket-config');

let onlineShops = [];

function findOnlineShopByShopId(shopId) {
	return onlineShops.find((shop) => shop.shopId === shopId);
}

async function updateShopChatHistory(userId, shopId, newMessage) {
	const shopDocs = await ShopChat.findOne({ userId, shopId });
	if (shopDocs) {
		await ShopChat.updateOne(
			{ _id: shopDocs._id },
			{ $push: { history: newMessage } },
		);
	} else {
		await ShopChat.create({
			userId,
			shopId,
			createdAt: newMessage.time,
			history: [newMessage],
		});
	}
}

shopIO.on('connection', function (socket) {
	socket.on('fc shop online', async (shopId) => {
		onlineShops.push({ socketId: socket.id, shopId });
		socket.join(`shop-${shopId}`);
		shopIO.to(`shop-${shopId}`).emit('fs shop online');
		Shop.update({ isOnline: true }, { where: { shopId } });
	});

	socket.on('fc user connect', (data) => {
		const { userId, shopId } = data;
		socket.join([`shop-${shopId}`, `user-${userId}`]);
	});

	socket.on('fc user chat', async (data) => {
		const { userId, shopId, message, time } = data;

		const newMessage = { isUser: true, content: message, time };
		const onlineShop = findOnlineShopByShopId(shopId);

		if (onlineShop) {
			shopIO
				.to(onlineShop.socketId)
				.emit('fs user chat', { userId, ...newMessage });
		}

		await updateShopChatHistory(userId, shopId, newMessage);
	});

	socket.on('fc shop chat', async (data) => {
		const { userId, shopId, message, time } = data;
		const newMessage = { isUser: false, content: message, time };
		shopIO.to(`user-${userId}`).emit('fs shop chat', newMessage);
		await updateShopChatHistory(userId, shopId, newMessage);
	});

	socket.on('disconnect', () => {
		const index = onlineShops.findIndex((item) => item.socketId === socket.id);

		if (index !== -1) {
			const { shopId } = onlineShops[index];
			onlineShops.splice(index, 1);
			shopIO.to(`shop-${shopId}`).emit('fs shop offline');
			Shop.update({ isOnline: false }, { where: { shopId } });
		}
	});
});
