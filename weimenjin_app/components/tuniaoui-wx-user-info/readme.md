
# 使用说明

使用方法：

```
<template>
    <view class="">
      <!-- 显示获取用户头像、昵称信息弹框 -->
    	<tnui-wx-user-info
    	  v-model="showAuthorizationModal"
    	  @updated="updatedUserInfoEvent"
    	></tnui-wx-user-info>
    </view>
</template>
<script>
  import TnuiWxUserInfo from '@/uni_modules/tn-wx-user-info/components/tnui-wx-user-info/tnui-wx-user-info'
	export default {
    components: { TnuiWxUserInfo },
		data() {
			return {
				showAuthorizationModal: false
			}
		},
    methods: {
      // 获取到的用户信息
      updatedUserInfoEvent(info) {
        console.log('获取到的用户信息', info)
      }
    }
	}
</script>
```

参数说明：

| 参数       | 说明                                                 |
| :-------- | ---------------------------------------------------- |
| v-model   | 弹出、关闭设置用户信息弹框                               |

