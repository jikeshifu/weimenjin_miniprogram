// import { getGoodsList_api } from '@/api/index.js';
const MescrollMixin = {
	data() {
		return {
			noMore: 'loading',
			page: 1,
			queryList: {}
		}
	},
	onLoad() {
		// this.getList();
	},
	methods: {
		async getList() {
			try {
				this._requestBefore && this._requestBefore();
			} catch (error) {
				console.log(error);
			}
			this.noMore = 'loading';
			let params = {
				page: this.page,
				page_size: 10,
				...this.queryList
			};			
			
			let res = await this.dataList_api(params);
			this.resData = res
			if (this.page !== 1 && !res.data.data.length) {
				this.noMore = 'noMore';
				return;
			} else if (this.page === 1 && !res.data.data.length) {
				this.dataList = [];
				this.dataList = res.data.data;
				this.noMore = 'nodata';
				return;
			}

			this.dataList = this.dataList.concat(res.data.data); //将数据拼接在一起
			if (this.dataList.length < 7) {
				this.noMore = 'noMore';
			}
		},
		
		// 重置
		resetQuest_api() {
			this.page = 1;
			this.dataList = [];
			this.getList();
		}
	},


	onReachBottom() {
		if (this.noMore === 'noMore' || this.noMore === 'nodata') {
			return;
		}
		this.page++; //每触底一次 page +1
		this.getList();
	},
	onPullDownRefresh() {
		let that = this;
		this.page = 1;
		setTimeout(() => {
			uni.stopPullDownRefresh();
			that.dataList = [];
			that.getList();
		}, 1000);
	}

}

export default MescrollMixin;
