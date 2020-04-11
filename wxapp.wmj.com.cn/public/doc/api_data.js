define({ "api": [
  {
    "type": "get",
    "url": "/Base/captcha",
    "title": "02、图片验证码地址",
    "group": "Base",
    "version": "1.0.0",
    "description": "<p>图片验证码</p>",
    "success": {
      "examples": [
        {
          "title": "01 调用示例",
          "content": "<img src=\"http://xxxx.com/Base/captcha\" onClick=\"this.src=this.src+'?'+Math.random()\" alt=\"点击刷新验证码\">",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Base.php",
    "groupTitle": "Base",
    "name": "GetBaseCaptcha"
  },
  {
    "type": "post",
    "url": "/Base/upload",
    "title": "01、图片上传",
    "group": "Base",
    "version": "1.0.0",
    "description": "<p>图片上传</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回图片地址</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Base.php",
    "groupTitle": "Base",
    "name": "PostBaseUpload"
  },
  {
    "type": "post",
    "url": "/Health/add",
    "title": "01、添加",
    "group": "Health",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>姓名 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号 手机号</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "first_address",
            "description": "<p>居住地址 (必填) 第一居住地址</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "second_address",
            "description": "<p>第二居住地址 第二居住地址</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "position",
            "description": "<p>当前位置 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "job",
            "description": "<p>工作或学习单位 工作或学习单位</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "yiqu",
            "description": "<p>疫区 (必填) 30日内是否来自疫区,1是,2否</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "register_type",
            "description": "<p>登记类型 (必填) 登记类型默认1村居,2乡镇社区,3区县,4交通运输,5校园</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "health",
            "description": "<p>健康状况 (必填) 健康状况默认1健康,2异常,3其他</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "manyou",
            "description": "<p>漫游地截图 漫游地截图</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "txz",
            "description": "<p>证明图片 证明图片</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lat",
            "description": "<p>经度</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lng",
            "description": "<p>纬度</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>所属用户</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "openid",
            "description": "<p>openid</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "regpoint_id",
            "description": "<p>登记点ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Health.php",
    "groupTitle": "Health",
    "name": "PostHealthAdd"
  },
  {
    "type": "post",
    "url": "/Health/list",
    "title": "02、查看数据列表",
    "group": "Health",
    "version": "1.0.0",
    "description": "<p>查看数据列表</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "mobile",
            "description": "<p>手机号 手机号</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "position",
            "description": "<p>当前位置</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "create_time_start",
            "description": "<p>创建时间开始</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "create_time_end",
            "description": "<p>创建时间结束</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "openid",
            "description": "<p>openid</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Health.php",
    "groupTitle": "Health",
    "name": "PostHealthList"
  },
  {
    "type": "post",
    "url": "/Health/view",
    "title": "03、查看数据详情页",
    "group": "Health",
    "version": "1.0.0",
    "description": "<p>查看数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "health_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Health.php",
    "groupTitle": "Health",
    "name": "PostHealthView"
  },
  {
    "type": "post",
    "url": "/Health/viewrecently",
    "title": "04、根据openid获取最近填写的记录",
    "group": "Health",
    "version": "1.0.0",
    "description": "<p>查看数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "openid",
            "description": "<p>openid</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Health.php",
    "groupTitle": "Health",
    "name": "PostHealthViewrecently"
  },
  {
    "type": "post",
    "url": "/LockAuth/applyauth",
    "title": "02、申请钥匙",
    "group": "LockAuth",
    "version": "1.0.0",
    "description": "<p>申请钥匙</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "lock_id",
            "description": "<p>锁ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "realname",
            "description": "<p>姓名</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "remark",
            "description": "<p>备注</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_status",
            "description": "<p>审核状态 已审核|1,未审核|0</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "user_id",
            "description": "<p>管理员ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/LockAuth.php",
    "groupTitle": "LockAuth",
    "name": "PostLockauthApplyauth"
  },
  {
    "type": "post",
    "url": "/LockAuth/delete",
    "title": "04、删除",
    "group": "LockAuth",
    "version": "1.0.0",
    "description": "<p>删除</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lockauth_ids",
            "description": "<p>主键id 注意后面跟了s 多数据删除</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/LockAuth.php",
    "groupTitle": "LockAuth",
    "name": "PostLockauthDelete"
  },
  {
    "type": "post",
    "url": "/LockAuth/getauthdetailbyid",
    "title": "05、查看数据",
    "group": "LockAuth",
    "version": "1.0.0",
    "description": "<p>查看数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lockauth_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/LockAuth.php",
    "groupTitle": "LockAuth",
    "name": "PostLockauthGetauthdetailbyid"
  },
  {
    "type": "post",
    "url": "/LockAuth/getauthlistbymemid",
    "title": "01、会员id查询钥匙列表",
    "group": "LockAuth",
    "version": "1.0.0",
    "description": "<p>会员id查询钥匙</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/LockAuth.php",
    "groupTitle": "LockAuth",
    "name": "PostLockauthGetauthlistbymemid"
  },
  {
    "type": "post",
    "url": "/LockAuth/getkey",
    "title": "07、领取钥匙",
    "group": "LockAuth",
    "version": "1.0.0",
    "description": "<p>领取钥匙</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lockauth_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/LockAuth.php",
    "groupTitle": "LockAuth",
    "name": "PostLockauthGetkey"
  },
  {
    "type": "post",
    "url": "/LockAuth/shareauth",
    "title": "06、分享钥匙",
    "group": "LockAuth",
    "version": "1.0.0",
    "description": "<p>生成分享前的临时钥匙</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "lock_id",
            "description": "<p>锁ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_member_id",
            "description": "<p>分享人会员ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_sharelimit",
            "description": "<p>可分享钥匙数</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_openlimit",
            "description": "<p>开门限制次数</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "auth_starttime",
            "description": "<p>有效期起始时间</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "auth_endtime",
            "description": "<p>有效期结束时间</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_shareability",
            "description": "<p>分享权限 开启|1,关闭|0</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "auth_opentimes",
            "description": "<p>可开时段</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "remark",
            "description": "<p>备注</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_status",
            "description": "<p>审核状态 已审核|1,未审核|0</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "user_id",
            "description": "<p>管理员ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/LockAuth.php",
    "groupTitle": "LockAuth",
    "name": "PostLockauthShareauth"
  },
  {
    "type": "post",
    "url": "/LockAuth/verifyauth",
    "title": "03、审核钥匙",
    "group": "LockAuth",
    "version": "1.0.0",
    "description": "<p>审核钥匙</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lockauth_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "lock_id",
            "description": "<p>锁ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_member_id",
            "description": "<p>分享人会员ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_sharelimit",
            "description": "<p>可分享钥匙数</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_openlimit",
            "description": "<p>开门限制次数</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "auth_starttime",
            "description": "<p>有效期起始时间</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "auth_endtime",
            "description": "<p>有效期结束时间</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_isadmin",
            "description": "<p>是否管理员</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_shareability",
            "description": "<p>分享权限 开启|1,关闭|0</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "remark",
            "description": "<p>备注</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "create_time",
            "description": "<p>创建时间</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "auth_status",
            "description": "<p>审核状态 已审核|1,未审核|0</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "user_id",
            "description": "<p>管理员ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/LockAuth.php",
    "groupTitle": "LockAuth",
    "name": "PostLockauthVerifyauth"
  },
  {
    "type": "post",
    "url": "/LockLog/getopenlog",
    "title": "01、获取开门日志",
    "group": "LockLog",
    "version": "1.0.0",
    "description": "<p>获取开门日志</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/LockLog.php",
    "groupTitle": "LockLog",
    "name": "PostLocklogGetopenlog"
  },
  {
    "type": "post",
    "url": "/Lock/add",
    "title": "01、添加",
    "group": "Lock",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lock_name",
            "description": "<p>锁名称 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lock_sn",
            "description": "<p>序列号 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "mobile_check",
            "description": "<p>绑定手机 是|1|primary,否|0|info</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "getkey",
            "description": "<p>领取钥匙 开启|1,关闭|0</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "getkey_check",
            "description": "<p>审核钥匙 开启|1,关闭|0</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "status",
            "description": "<p>开关 启用|1|success,禁用|0|danger</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "lock_type",
            "description": "<p>类型</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "location",
            "description": "<p>位置</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Lock.php",
    "groupTitle": "Lock",
    "name": "PostLockAdd"
  },
  {
    "type": "post",
    "url": "/Lock/delete",
    "title": "03、删除",
    "group": "Lock",
    "version": "1.0.0",
    "description": "<p>删除</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lock_ids",
            "description": "<p>主键id 注意后面跟了s 多数据删除</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Lock.php",
    "groupTitle": "Lock",
    "name": "PostLockDelete"
  },
  {
    "type": "post",
    "url": "/Lock/opendoor",
    "title": "05、开门",
    "group": "Lock",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "lock_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "user_id",
            "description": "<p>管理员ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>1扫码开门,2菜单开门,管理员开门 (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.opendoor_status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.opendoor_status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ],
        "需要绑定手机返回参数：": [
          {
            "group": "需要绑定手机返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "需要绑定手机返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.opendoor_status",
            "description": "<p>返回错误码 202</p>"
          },
          {
            "group": "需要绑定手机返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回需要绑定手机消息</p>"
          }
        ],
        "需要申请钥匙且审核返回参数：": [
          {
            "group": "需要申请钥匙且审核返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "需要申请钥匙且审核返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.opendoor_status",
            "description": "<p>返回错误码 203</p>"
          },
          {
            "group": "需要申请钥匙且审核返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回需要申请钥匙且审核消息</p>"
          }
        ],
        "需要申请钥匙返回参数：": [
          {
            "group": "需要申请钥匙返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "需要申请钥匙返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.opendoor_status",
            "description": "<p>返回错误码 204</p>"
          },
          {
            "group": "需要申请钥匙返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回需要申请钥匙消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"opendoor_status\":\"200\",\"msg\":\"开门成功\",'successimg'=>'/uploads/admin/202003/5e758dd0d7d15.png','successadimg'=>'/uploads/admin/202003/5e758e6fe9216.png'}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"opendoor_status\":\"201\",\"msg\":\"错误信息\"}",
          "type": "json"
        },
        {
          "title": "03 需要绑定手机示例",
          "content": "{\"opendoor_status\":\"202\",\"msg\":\"需要绑定手机号\"}",
          "type": "json"
        },
        {
          "title": "04 需要申请钥匙且审核示例",
          "content": "{\"opendoor_status\":\"203\",\"msg\":\"需要申请钥匙且审核\"}",
          "type": "json"
        },
        {
          "title": "05 需要申请钥匙示例",
          "content": "{\"opendoor_status\":\"204\",\"msg\":\"需要申请钥匙\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Lock.php",
    "groupTitle": "Lock",
    "name": "PostLockOpendoor"
  },
  {
    "type": "post",
    "url": "/Lock/update",
    "title": "02、修改",
    "group": "Lock",
    "version": "1.0.0",
    "description": "<p>修改</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lock_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员id</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lock_name",
            "description": "<p>锁名称 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lock_sn",
            "description": "<p>序列号 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "mobile_check",
            "description": "<p>绑定手机 是|1|primary,否|0|info</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "getkey",
            "description": ""
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "getkey_check",
            "description": ""
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "status",
            "description": "<p>开关 启用|1|success,禁用|0|danger</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "lock_type",
            "description": "<p>类型</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "location",
            "description": "<p>位置</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "create_time",
            "description": "<p>添加时间</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lock_qrcode",
            "description": "<p>二维码</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "online",
            "description": "<p>状态 在线|1|primary,离线|0|warning</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Lock.php",
    "groupTitle": "Lock",
    "name": "PostLockUpdate"
  },
  {
    "type": "post",
    "url": "/Lock/view",
    "title": "04、查看数据",
    "group": "Lock",
    "version": "1.0.0",
    "description": "<p>查看数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "lock_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Lock.php",
    "groupTitle": "Lock",
    "name": "PostLockView"
  },
  {
    "type": "post",
    "url": "/Locktimes/getopentimes",
    "title": "01、查询可开门时段",
    "group": "Locktimes",
    "version": "1.0.0",
    "description": "<p>查询可开门时段</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "lock_id",
            "description": "<p>锁ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Locktimes.php",
    "groupTitle": "Locktimes",
    "name": "PostLocktimesGetopentimes"
  },
  {
    "type": "post",
    "url": "/Member/alipaylogin",
    "title": "05、支付宝小程序登录",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>支付宝小程序登录</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>小程序传入</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Member.php",
    "groupTitle": "Member",
    "name": "PostMemberAlipaylogin"
  },
  {
    "type": "post",
    "url": "/Member/getphonenumber",
    "title": "08、获取绑定手机号",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>获取绑定手机号</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>小程序传入</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "encryptedData",
            "description": "<p>小程序传入</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "iv",
            "description": "<p>小程序传入</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Member.php",
    "groupTitle": "Member",
    "name": "PostMemberGetphonenumber"
  },
  {
    "type": "post",
    "url": "/Member/update",
    "title": "02、更新用户信息",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>编辑数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "nickname",
            "description": "<p>呢称</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "headimgurl",
            "description": "<p>头像</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "openid",
            "description": "<p>openid</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "sex",
            "description": "<p>性别</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Member.php",
    "groupTitle": "Member",
    "name": "PostMemberUpdate"
  },
  {
    "type": "post",
    "url": "/Member/view",
    "title": "03、查看用户信息",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>查看用户信息</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Member.php",
    "groupTitle": "Member",
    "name": "PostMemberView"
  },
  {
    "type": "post",
    "url": "/Member/viewuserid",
    "title": "04、查询管理员ID",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>查询管理员ID</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Member.php",
    "groupTitle": "Member",
    "name": "PostMemberViewuserid"
  },
  {
    "type": "post",
    "url": "/Member/xcxlogin",
    "title": "01、小程序登录",
    "group": "Member",
    "version": "1.0.0",
    "description": "<p>小程序登录</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>小程序传入</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "encryptedData",
            "description": "<p>小程序传入</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "iv",
            "description": "<p>小程序传入</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>扫码带过来的管理员id</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Member.php",
    "groupTitle": "Member",
    "name": "PostMemberXcxlogin"
  },
  {
    "type": "post",
    "url": "/Regpoint/add",
    "title": "01、添加",
    "group": "Regpoint",
    "version": "1.0.0",
    "description": "<p>添加</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "regpointname",
            "description": "<p>名称</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "regpointurl",
            "description": "<p>注册点url</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Regpoint.php",
    "groupTitle": "Regpoint",
    "name": "PostRegpointAdd"
  },
  {
    "type": "post",
    "url": "/Regpoint/delete",
    "title": "02、删除",
    "group": "Regpoint",
    "version": "1.0.0",
    "description": "<p>删除</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "regpoint_ids",
            "description": "<p>主键id 注意后面跟了s 多数据删除</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Regpoint.php",
    "groupTitle": "Regpoint",
    "name": "PostRegpointDelete"
  },
  {
    "type": "post",
    "url": "/Regpoint/index",
    "title": "01、登记点列表",
    "group": "Regpoint",
    "version": "1.0.0",
    "description": "<p>登记点管理</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>每页数据条数（默认20）</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": true,
            "field": "page",
            "description": "<p>当前页码</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "regpointname",
            "description": "<p>名称</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "regpointurl",
            "description": "<p>注册点url</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "create_time_start",
            "description": "<p>创建时间开始</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": true,
            "field": "create_time_end",
            "description": "<p>创建时间结束</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.list",
            "description": "<p>返回数据列表</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data.count",
            "description": "<p>返回数据总数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"查询失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Regpoint.php",
    "groupTitle": "Regpoint",
    "name": "PostRegpointIndex"
  },
  {
    "type": "post",
    "url": "/Regpoint/update",
    "title": "01、修改",
    "group": "Regpoint",
    "version": "1.0.0",
    "description": "<p>修改</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "regpoint_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "regpointname",
            "description": "<p>名称</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "regpointurl",
            "description": "<p>注册点url</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "create_time",
            "description": "<p>创建时间</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Regpoint.php",
    "groupTitle": "Regpoint",
    "name": "PostRegpointUpdate"
  },
  {
    "type": "post",
    "url": "/Regpoint/view",
    "title": "03、查看数据",
    "group": "Regpoint",
    "version": "1.0.0",
    "description": "<p>查看数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "regpoint_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/Regpoint.php",
    "groupTitle": "Regpoint",
    "name": "PostRegpointView"
  },
  {
    "type": "post",
    "url": "/User/adduser",
    "title": "00、添加后台管理员",
    "group": "User",
    "version": "1.0.0",
    "description": "<p>创建数据</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>真实姓名 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user",
            "description": "<p>用户名 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "pwd",
            "description": "<p>密码 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员id (必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\": \"200\", \"user_id\": \"23\", \"msg\": \"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/User.php",
    "groupTitle": "User",
    "name": "PostUserAdduser"
  },
  {
    "type": "post",
    "url": "/User/update",
    "title": "01、修改",
    "group": "User",
    "version": "1.0.0",
    "description": "<p>修改账户</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>主键ID (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>真实姓名 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user",
            "description": "<p>用户名 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "group_id",
            "description": "<p>所属分组 (必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "type",
            "description": "<p>类别 超级管理员|1|success,普通管理员|2|warning</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "note",
            "description": "<p>备注</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "status",
            "description": "<p>状态 正常|1|primary,禁用|0|danger</p>"
          },
          {
            "group": "输入参数：",
            "type": "int",
            "optional": false,
            "field": "member_id",
            "description": "<p>会员ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "create_time",
            "description": "<p>创建时间</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码  201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\" 201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/User.php",
    "groupTitle": "User",
    "name": "PostUserUpdate"
  },
  {
    "type": "post",
    "url": "/User/updatePassword",
    "title": "02、修改密码",
    "group": "User",
    "version": "1.0.0",
    "description": "<p>修改密码</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>主键ID</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "pwd",
            "description": "<p>新密码(必填)</p>"
          },
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "repwd",
            "description": "<p>重复密码(必填)</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回成功消息</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"msg\":\"操作成功\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"操作失败\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/User.php",
    "groupTitle": "User",
    "name": "PostUserUpdatepassword"
  },
  {
    "type": "post",
    "url": "/User/view",
    "title": "03、查询管理员",
    "group": "User",
    "version": "1.0.0",
    "description": "<p>查询管理员</p>",
    "parameter": {
      "fields": {
        "输入参数：": [
          {
            "group": "输入参数：",
            "type": "string",
            "optional": false,
            "field": "user_id",
            "description": "<p>主键ID</p>"
          }
        ],
        "失败返回参数：": [
          {
            "group": "失败返回参数：",
            "type": "object",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 201</p>"
          },
          {
            "group": "失败返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.msg",
            "description": "<p>返回错误消息</p>"
          }
        ],
        "成功返回参数：": [
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array",
            "description": "<p>返回结果集</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.status",
            "description": "<p>返回错误码 200</p>"
          },
          {
            "group": "成功返回参数：",
            "type": "string",
            "optional": false,
            "field": "array.data",
            "description": "<p>返回数据详情</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>用户授权token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-示例:",
          "content": "\"Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org\"",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "01 成功示例",
          "content": "{\"status\":\"200\",\"data\":\"\"}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "02 失败示例",
          "content": "{\"status\":\"201\",\"msg\":\"没有数据\"}",
          "type": "json"
        }
      ]
    },
    "filename": "./controller/User.php",
    "groupTitle": "User",
    "name": "PostUserView"
  }
] });
