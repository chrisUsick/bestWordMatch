export class Echo {
  constructor (containerSelector) {
    this.elem = $(containerSelector);
    this.model = {
      message:'type a message',
      messages:[]
    };
    rivets.bind(this.elem, this.model);

    this.model.submit = (e) => {
      let data = {message:this.model.message, name:this.model.name};
      ws.send(JSON.stringify(data));
    }.bind(this);
    const host = location.host.split(':')[0];
    let ws = new WebSocket(`ws://${host}:9090/echo`);
    this.ws = ws;
    ws.onclose = (event) => console.log('closed connection', event);
    ws.onopen = (event) => {
      console.log('opened', event);
      this.WSConnected = true;
      this.model.connected = this.WSConnected && this.nameIsSet;

      // ws.close();
    }.bind(this);
    ws.onmessage = (e) => {
      console.log('message', e);
      const data = JSON.parse(e.data);
      this.model.messages.push({message:data.message, name:data.name});
      if (data.message == 'close') {
        this.ws.close();
      }
    }.bind(this);
  }

  /**
   * when the name is set, the user may send messages
   */
  setName(name) {
    this.model.name = name;
    this.nameIsSet = true;
    this.model.connected = this.WSConnected && this.nameIsSet;
  }
}
