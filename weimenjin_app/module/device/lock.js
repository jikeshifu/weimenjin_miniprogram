import { assetUrl } from '@/config/domain.js';

const OpenLockMp3 = function(deviceSn, lock_id = 0) {
	const innerAudioContext = wx.createInnerAudioContext({
		useWebAudioImplement: true
	});
	innerAudioContext.src = assetUrl('/mydkmp3.mp3');
	innerAudioContext.play();
};

export default {
	OpenLockMp3
};
