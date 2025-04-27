const OpenLockMp3 = function(deviceSn, lock_id = 0) {
	const innerAudioContext = wx.createInnerAudioContext({
		useWebAudioImplement: true
	});
	innerAudioContext.src = 'https://demo.wmj.com.cn/mydkmp3.mp3';
	innerAudioContext.play();
};

export default {
	OpenLockMp3
};