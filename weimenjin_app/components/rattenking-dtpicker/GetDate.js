const GetDate = {
  withData: (num) => {
		let param = parseInt(num);
    return param < 10 ? '0' + param : '' + param;
  },
  getTimes(str){
    return new Date(str.replace(/-/g,'/')).getTime();
  },
	getCurrentTimes(){
		const date = new Date();
		const year = date.getFullYear();
		const month = date.getMonth() + 1;
		const day = date.getDate();
		const hour = date.getHours();
		const minute = date.getMinutes();
		const second = date.getSeconds();
		return {
			detail: {
				year: year,
				month: month,
				day: day,
				hour: hour,
				minute: minute,
				second: second
			}
		}
	},
  format(arr){
    let curarr = [];
    let curarr0 = [];
    let str = '';
    arr.forEach((cur,index) => {
			let o = GetDate.withData(cur);
      if(index > 2){
        curarr.push(o);
      }else{
        curarr0.push(o);
      }
    })
    if(arr.length < 4){
      str = curarr0.join('-');
    }else{
      str = curarr0.join('-') + ' ' + curarr.join(':');
    }
    return str;
  },
	getCurrentStringValue(str){
		let newstr = str.split(' ');
		if(newstr && newstr[1]){
			let arr = [...newstr[0].split('-'),...newstr[1].split(':')];
			return arr;
		}
		return newstr[0].split('-');
	},
	getCompare(curp,startp,endp,timesp){
		let cur = GetDate.getTimes(curp);
		let start = GetDate.getTimes(startp);
		let end = GetDate.getTimes(endp);
		if(cur < start){
			return GetDate.getTimeIndex(timesp,GetDate.getCurrentStringValue(startp));
		}else if(cur > end){
			return GetDate.getTimeIndex(timesp,GetDate.getCurrentStringValue(endp));
		}else{
			return GetDate.getTimeIndex(timesp,GetDate.getCurrentStringValue(curp));
		}
	},
	getChooseArr(times,indexs){
		let arr = [];
		times.forEach((cur,index) => arr.push(cur[indexs[index]]));
		return arr;
	},
	getNewArray(arr){
		let newarr = [];
		arr.forEach(cur => newarr.push(cur));
		return newarr;
	},
  getLoopArray: (start, end) => {
    var start = start || 0;
    var end = end || 1;
    var array = [];
    for (var i = start; i <= end; i++) {
      array.push(GetDate.withData(i));
    }
    return array;
  },
  getMonthDay: (year, month) => {
    var flag = year % 400 == 0 || (year % 4 == 0 && year % 100 != 0), array = null;

    switch (month) {
      case '01':
      case '03':
      case '05':
      case '07':
      case '08':
      case '10':
      case '12':
        array = GetDate.getLoopArray(1, 31)
        break;
      case '04':
      case '06':
      case '09':
      case '11':
        array = GetDate.getLoopArray(1, 30)
        break;
      case '02':
        array = flag ? GetDate.getLoopArray(1, 29) : GetDate.getLoopArray(1, 28)
        break;
      default:
        array = '月份格式不正确，请重新输入！'
    }
    return array;
  },
  getDateTimes: (opts) => {
    var years = GetDate.getLoopArray(opts.start, opts.end);
    var months = GetDate.getLoopArray(1, 12);
    var days = GetDate.getMonthDay(opts.curyear, opts.curmonth);
    var hours = GetDate.getLoopArray(0, 23);
    var minutes = GetDate.getLoopArray(0, 59);
    var seconds = GetDate.getLoopArray(0, 59);
    var times = null;

    switch (opts.fields) {
      case 'year':
        times = [years]
        break;
      case 'month':
        times = [years, months]
        break;
      case 'day':
        times = [years, months, days]
        break;
      case 'hour':
        times = [years, months, days, hours]
        break;
      case 'minute':
        times = [years, months, days, hours, minutes]
        break;
      case 'second':
        times = [years, months, days, hours, minutes, seconds]
        break;
      default:
        times = [years, months, days, hours, minutes, seconds]
    }
    return times;
  },
  getIndex(arr,target){
    let len = arr.length;
    for(let i = 0; i < len; i++){
      if(arr[i] == target){
        return i;
      }
    }
  },
  getTimeIndex(arrs, targets){
    let len = arrs.length;
    let arr = [];
    for(let i = 0; i < len; i++){
      arr.push(GetDate.getIndex(arrs[i], targets[i]))
    }
    return arr;
  },
  error(str){
	  console.error(str);
  }
}

module.exports = GetDate; 