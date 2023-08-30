# 轮播组件

# 基础式
 <ls-swiper :list="base_lsit" imgKey="imgUrl" :loop="true" :dots='true' :autoplay='true' @clickItem="clickItem()" />

# 链式
<ls-swiper :list="list" imgKey="imgUrl" imgWidth="300" previousMargin="20" nextMargin='20'/>

# 卡片式
<ls-swiper :list="base_lsit" imgKey="imgUrl" :crown="true" :loop="true" :shadow='true' height='130' previousMargin="120" nextMargin='120' imgRadius="5" />

# props
参数名           |  说明                                              | 类型        |   默认值
-----------------|-------------------------------------------------- -|-------------|------------
list             |  轮播数据                                          | Array       |  必输
imgKey           |  轮播数据key（图片url属性）                         | String      |  必输  (自定义模式，非必输)
autoplay         |  是否自动播放                                      | Boolean     |  false
loop             |  是否循环                                          | Boolean     |  false
autoplay         |  是否自动播放                                      | Boolean     |  false
dots             |  是否显示轮播点                                    | Boolean     |  false
crown            |  卡片特效 (中间突出，两边缩放特效)                  | Boolean     |  false
interval         |  播放时间间隔                                      | Number      |  2000
duration         |  滑动速度                                          | Number      |  1500
bottom           |  轮播点下边距                                      | Number      |  10    (单位:px,设计图建议以375px为准)
height           |  高度                                              | Number      |  200   (单位:px,设计图建议以375px为准)
previousMargin   |  图片前边距                                        | Number      |  0     (单位:px,设计图建议以375px为准)
nextMargin       |  图片后间距                                        | Number      |  0     (单位:px,设计图建议以375px为准)
imgRadius        |  图片圆角                                          | Number      |  0     (单位:px,设计图建议以375px为准)
imgWidth         |  图片宽度                                          | String      |  100%
@clickItem       |  点击事件                                          | Function    |  
@change          |  切换事件                                          | Function    |  

# 自定义
<ls-swiper :list="list">
 <template v-slot="{data}">
	xxx
 </template>
</ls-swiper>

如有其他需求，可在插槽内编写自定义内容, 自动覆盖原图片样式。  