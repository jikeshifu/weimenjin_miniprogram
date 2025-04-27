<template>
  <view class="cmd-circle">
    <canvas :canvas-id="cid" :style="calCircleStyle"></canvas>
  </view>
</template>

<script>
  /**
   * 进度圈组件  
   * @description 用圈显示一个操作完成的百分比时，为用户显示该操作的当前进度和状态。  
   * @tutorial https://ext.dcloud.net.cn/plugin?id=259  
   * @property {String} cid 画布编号 - 默认defaultCanvas  
   * @property {String} type 进度圈类型 - 圆圈形：circle、仪表盘：dashboard，默认圆圈形：circle  
   * @property {Number} percent 进度圈百分比值 - 显示范围0-100 ，可能数比较大就需要自己转成百分比的值  
   * @property {Boolean} show-info 进度圈进度状态信息 - 显示进度数值或状态图标，默认true  
   * @property {String} font-color 进度圈文字信息颜色  
   * @property {String} font-size 进度圈文字信息大小 - 默认：14  
   * @property {String} status 进度圈状态 - 正常：normal、完成：success、失败：exception，默认正常：normal  
   * @property {Number} stroke-width 进度圈线条宽度 - 建议在条线的宽度范围：1-50，与进度条显示宽度有关，默认：6  
   * @property {String} stroke-color 进度圈的颜色 - 设置后status状态无效  
   * @property {String} stroke-background 进度圈的底圈颜色 - 默认：#eeeeee  
   * @property {String} stroke-shape 进度圈两端的形状 - 圆：round、方直角：square，默认圆：round  
   * @property {Number} width 进度圈布宽度 - 默认80  
   * @property {String} gap-degree 进度圈形缺口角度 - 可取值 0 ~ 360，仅支持类型：circle  
   * @property {String} gap-position 进度圈形缺口位置 - 可取值'top', 'bottom', 'left', 'right'，仅支持类型：circle  
   * @example <cmd-circle id="circle1" type="circle" :percent="75"></cmd-circle>  
   */
  export default {
    name: "cmd-circle",

    props: {
      // 画布编号 默认defaultCanvas
      cid: {
        type: String,
        default: "defaultCanvas"
      },
      // 圈类型默认：circle，可选 circle dashboard
      type: {
        type: String,
        validator: val => {
          return ['circle', 'dashboard'].includes(val);
        },
        default: 'circle'
      },
      // 圈进度百分比值
      percent: {
        type: Number,
        validator: val => {
          return val >= 0 && val <= 100;
        },
        default: 0
      },
      // 圈是否显示进度数值或状态图标
      showInfo: {
        type: Boolean,
        default: true
      },
      // 圈文字信息颜色
      fontColor: {
        type: String,
        default: "#595959"
      },
      // 圈文字信息大小 默认14
      fontSize: {
        type: Number,
        default: 14
      },
      // 圈进度状态，可选：normal success exception
      status: {
        type: String,
        validator: val => {
          return ['normal', 'success', 'exception'].includes(val);
        },
        default: 'normal'
      },
      // 圈线条宽度1-50，与width有关
      strokeWidth: {
        type: Number,
        default: 6
      },
      // 圈的颜色，设置后status状态无效
      strokeColor: {
        type: String,
        default: ''
      },
      // 圈的底圈颜色 默认：#eeeeee
      strokeBackground: {
        type: String,
        default: '#eeeeee'
      },
      // 圈两端的形状 可选：'round', 'square'
      strokeShape: {
        type: String,
        validator: val => {
          return ['round', 'square'].includes(val);
        },
        default: 'round'
      },
      // 圈画布宽度
      width: {
        type: Number,
        default: 80
      },
      // 圈缺口角度，可取值 0 ~ 360，仅支持类型：circle  
      gapDegree: {
        type: Number,
        validator: val => {
          return val >= 0 && val <= 360;
        },
        default: 360
      },
      // 圈缺口开始位置,可取值'top', 'bottom', 'left', 'right'，仅支持类型：circle  
      gapPosition: {
        type: String,
        validator: val => {
          return ['top', 'bottom', 'left', 'right'].includes(val);
        },
        default: 'top'
      }
    },

    data() {
      return {
        // 画布实例
        ctx: {},
        // 圈半径
        width2px: ""
      }
    },

    computed: {
      // 计算设置圈样式
      calCircleStyle() {
        return `width: ${this.width}px;
				height: ${this.width}px;`
      },
      // 计算圈状态
      calStatus() {
        let status = {}
        switch (this.status) {
          case 'normal':
            status = {
              color: "#1890ff",
              value: 1
            };
            break;
          case 'success':
            status = {
              color: "#52c41a",
              value: 2
            };
            break;
          case 'exception':
            status = {
              color: "#f5222d",
              value: 3
            };
            break;
        }
        return status
      },
      // 计算圈缺口角度
      calGapDegree() {
        return this.gapDegree <= 0 ? 360 : this.gapDegree
      },
      // 计算圈缺口位置
      calGapPosition() {
        let gapPosition = 0
        switch (this.gapPosition) {
          case 'bottom':
            gapPosition = 90;
            break;
          case 'left':
            gapPosition = 180;
            break;
          case 'top':
            gapPosition = 270;
            break;
          case 'right':
            gapPosition = 360;
            break;
        }
        return gapPosition
      },
    },

    watch: {
      // 监听百分比值改变
      percent(val) {
        this.drawStroke(val);
      }
    },

    mounted() {
      // 创建画布实例
      this.ctx = uni.createCanvasContext(this.cid, this)
      // upx转px 圈半径大小
      this.width2px = uni.upx2px(this.width)
      // 绘制初始 
      this.$nextTick(() => {
        this.drawStroke(this.percent)
      })
    },

    methods: {
      // 绘制圈
      drawStroke(percent) {
        percent = percent >= 100 ? 100 : percent < 0 ? 0 : percent
        // 圈条进度色
        let color = this.strokeColor || this.calStatus.color
        // 是否圈中心显示信息
        if (this.showInfo) {
          switch (this.calStatus.value) {
            case 1:
              if (percent >= 100) {
                // 设置打勾
                this.drawSuccess()
                percent = 100
                color = "#52c41a"
              } else {
                // 设置字体
                this.drawText(percent)
              }
              break;
            case 2:
              // 设置打勾
              this.drawSuccess()
              percent = 100
              color = "#52c41a"
              break;
            case 3:
              // 设置打叉
              this.drawException()
              percent = 0
              color = "#f5222d"
              break;
            default:
              break;
          }
        }
        // 缺口
        let gapPosition = this.calGapPosition
        let gapDegree = this.calGapDegree
        // 仪表固定
        if (this.type === "dashboard") {
          gapPosition = 135
          gapDegree = 270
        }
        // 圈型条宽
        this.ctx.setLineCap(this.strokeShape)
        this.ctx.setLineWidth(this.strokeWidth)
        // 位置原点
        this.ctx.translate(this.width2px, this.width2px)
        // 缺口方向 
        this.ctx.rotate(gapPosition * Math.PI / 180)
        // 圈底 
        this.ctx.beginPath()
        this.ctx.arc(0, 0, this.width2px - this.strokeWidth, 0, gapDegree * Math.PI / 180)
        this.ctx.setStrokeStyle(this.strokeBackground)
        this.ctx.stroke()
        // 圈进度 
        this.ctx.beginPath()
        this.ctx.arc(0, 0, this.width2px - this.strokeWidth, 0, percent * gapDegree * Math.PI / 18000)
        this.ctx.setStrokeStyle(color)
        this.ctx.stroke()
        // 绘制
        this.ctx.draw()
      },
      // 绘制文字格式
      drawText(percent) {
        this.ctx.beginPath()
        this.ctx.setFontSize(this.fontSize)
        this.ctx.setFillStyle(this.fontColor)
        this.ctx.setTextAlign('center')
        this.ctx.fillText(`${percent}%`, this.width2px, this.width2px + this.fontSize / 2)
        this.ctx.stroke()
      },
      // 绘制成功打勾
      drawSuccess() {
        let x = this.width2px - this.fontSize / 2
        let y = this.width2px + this.fontSize / 2
        this.ctx.beginPath()
        this.ctx.setLineCap('round')
        this.ctx.setLineWidth(this.fontSize / 4)
        this.ctx.moveTo(this.width2px, y)
        this.ctx.lineTo(y, x)
        this.ctx.moveTo(this.width2px, y)
        this.ctx.lineTo(x, this.width2px)
        this.ctx.setStrokeStyle("#52c41a")
        this.ctx.stroke()
      },
      // 绘制异常打叉
      drawException() {
        let x = this.width2px - this.fontSize / 2
        let y = this.width2px + this.fontSize / 2
        this.ctx.beginPath()
        this.ctx.setLineCap('round')
        this.ctx.setLineWidth(this.fontSize / 4)
        this.ctx.moveTo(x, x)
        this.ctx.lineTo(y, y)
        this.ctx.moveTo(y, x)
        this.ctx.lineTo(x, y)
        this.ctx.setStrokeStyle("#f5222d")
        this.ctx.stroke()
      }
    }
  };
</script>

<style>
  .cmd-circle {
    display: inline-block;
    box-sizing: border-box;
    list-style: none;
    margin: 0;
    padding: 0;
  }
</style>
