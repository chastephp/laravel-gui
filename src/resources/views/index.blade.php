<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Laravel GUI</title>
    <style>
    html, body {
        width: 100%;
        height: 100%;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    * {
        box-sizing: border-box;
    }

    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
        height: 100%;
        width: 100%;
    }

    .layout {
        display: flex;
    }

    .layout-sider {
        width: 160px;
    }

    .layout-content {
        flex: 1;
    }
    </style>
    <style>
    .logo {
        margin-left: -1px;
        height: 64px;
        line-height: 64px;
        font-size: 24px;
        text-align: center;
        color: #fff;
    }

    .btn {
        color: #fff;
        outline: 0;
        -webkit-appearance: button;
        line-height: 1.5;
        background-color: #19be6b;
        display: inline-block;
        margin-bottom: 0;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        background-image: none;
        border: 1px solid #19be6b;
        white-space: nowrap;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        height: 32px;
        padding: 0 15px;
        font-size: 14px;
        border-radius: 4px;
    }

    .menu {
        display: block;
        margin: 0;
        padding: 0;
        outline: 0;
        list-style: none;
        color: #515a6e;
        font-size: 14px;
        position: relative;
        z-index: 900;
    }

    .menu-item {
        padding: 14px 24px;
        position: relative;
        cursor: pointer;
        z-index: 1;
        display: block;
        outline: 0;
        list-style: none;
        font-size: 14px;
    }

    .menu-item-selected {
        color: #2d8cf0;
        background: #363e4f;
    }

    .cmd-item-selected {
        color: #2d8cf0;
    }

    .command-input {
        margin: 0;
        display: inline-block;
        width: 100%;
        height: 32px;
        line-height: 1.5;
        padding: 4px 7px;
        font-size: 14px;
        border: 1px solid #dcdee2;
        border-radius: 4px;
        color: #515a6e;
        background-color: #fff;
        background-image: none;
        position: relative;
        cursor: text;
    }
    </style>
</head>
<body>
<noscript>
    <strong>We're sorry but wui doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>

<div id="app" v-show="visible" style="display: none">
    <div class="layout" style="height: 100%;">
        <div class="layout-sider" style="width: 160px;background: #515a6e;height: 100%">
            <div class="logo">GUI</div>
            <ul class="menu">
                <li class="menu-item menu-item-selected">Command</li>
            </ul>
        </div>
        <div class="layout-content">
            <div class="layout-header" style="padding: 0 50px;
    height: 64px;
    line-height: 64px;background: rgb(255, 255, 255);">
                <span style="font-size: 28px;">Command</span>
            </div>

            <div class="layout" style="height: 100%">
                <div class="layout-sider">
                    <ul class="menu" style="background: #fff;overflow: auto;height: calc(100vh - 64px);">
                        <div>
                            <input @keyup="handlePress" class="command-input" v-model="search" placeholder="search"
                                   style="width: 120px;margin: 0 10px"/>
                        </div>

                        <li :class="command.name == item.name ? 'menu-item cmd-item-selected' : 'menu-item' "
                            @click="handleCommandClick(item)" v-for="(item,key) in commands"
                            :key="item.name"
                            :title="item.description"
                            :name="key+1">
                            @{{item['name']}}
                        </li>
                    </ul>
                </div>
                <div class="layout-content" style="height: calc(100vh - 64px);overflow: auto;background: #f5f7f9;">
                    <div style="height: 100%;display: flex;flex-direction: column">
                        <div style="border-radius:3px;margin: 16px;background-color: #ffffff">
                            <div style="padding: 16px;font-size: 16px">
                                <div style="display: flex;align-items: center">
                                    <span> php artisan </span>
                                    <input type="text" class="command-input" v-model="inputCommand" placeholder=""
                                           style="width: 300px;margin-left: 10px;margin-right: 10px"/>
                                    <button @click="handleCommandExecute" class="btn">RUN</button>
                                </div>
                                <div class="help"
                                     style="padding-top: 10px;margin-top: 10px;min-height: 60px;border-top: 1px dotted #ccc">
                                    Usage:
                                    <div v-for="use in command.usage">
                                        @{{ use }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin: 16px;background-color: #000;color: #fff;
                                    flex: auto 1 1;border-radius: 3px;position: relative">
                            <div style="padding: 16px">
                                OUTPUT
                            </div>
                            <div style="height:calc(100vh - 312px);position: relative;">
                                <div v-html="output"
                                     style="padding: 16px;;white-space: pre-line;overflow-y: auto;max-height: 100%;height: 100%;width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
const commands = @json($commands);
var app = new Vue({
  el: '#app',
  data () {
    return {
      menu: 'command',
      visible: false,
      search: '',
      current: 0,
      inputCommand: '',
      command: {},
      output: '',
      commands: [],
    }
  },
  watch: {
    search: function () {
      this.commands = commands.filter(item => {
        return item.name.indexOf(this.search) !== -1
      })
      this.current = 0
    }
  },
  methods: {
    handlePress (evt) {
      const item = this.commands[this.current]
      if (evt.keyCode == 40) {// down
        this.current = this.current + 1
        if (this.current > this.commands.length) this.current = this.commands.length
        if (item) this.handleCommandClick(item)
      }
      if (evt.keyCode == 38) { // up
        this.current = this.current - 1
        if (this.current < 0) this.current = 0
        if (item) this.handleCommandClick(item)
      }
    },
    handleCommandClick (item) {
      this.command = item
      this.inputCommand = item.name + ' '
    },
    handleCommandExecute () {
      if (this.inputCommand) {
        // const loading = this.$Message.loading({content: 'Loading', duration: 2})

        fetch('/gui/execute', {
          method: 'POST', // or 'PUT'
          body: JSON.stringify({command: this.inputCommand}), // data can be `string` or {object}!
          headers: new Headers({
            'Content-Type': 'application/json'
          })
        }).then(res => res.json())
          .catch(error => console.error('Error:', error))
          .then(response => {
            if (response.code === 0) {
              console.log(response.data)
              this.output = response.data
            } else {
              this.$Message.error('命令执行错误')
            }
          })
      } else {
        this.$Message.error('命令不能为空')
      }
    }
  },
  mounted () {
    this.visible = true
    this.commands = commands
  }
})
</script>
</body>
</html>
