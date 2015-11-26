import {request} from "./request"

export class Game {
  constructor () {
    this.model = {
      showWaitingMsg: () => !this.model.gameStarted || this.model.registrationError
    };
    this.gameId = location.pathname.match(/\d+/)[0];
    this.playerId = localStorage.getItem('ticket');
    this.model.playerId = this.playerId;
    this.messageHandler = this.getMessageHandler();
    rivets.bind($("#app"), this.model);

    this.initWebSocket();
  }

  initWebSocket() {
    const host = location.host.split(':')[0];
    let ws = new WebSocket(`ws://${host}:9090/game`);
    this.ws = ws;
    ws.onclose = (event) => console.log('closed connection', event);
    ws.onopen = (event) => {
      console.log('opened', event);
      // ws.close();
      const data = {
        method:'game:register',
        gameId:this.gameId,
        playerId:this.playerId
      }
      ws.send(JSON.stringify(data));
    }.bind(this);

    ws.onmessage = (e) => {
      console.log('message', e);
      const data = JSON.parse(e.data);
      const handler = this.messageHandler;
      // if the handler has the method defined, call it
      if (Object.keys(handler).findIndex((k) => k == data.method) >= 0) {
        handler[data.method].call(this, data);
      }

    }.bind(this);
  }

  getMessageHandler () {
    return {
      'game:myHand':(data) => {
        this.model.myHand = data.cards;
        this.model.registered = true;
      }
      , 'game:registrationError': (data) => this.model.registrationError = data.error
      , 'game:gameReady': (data) => {
        this.model.greenCard = data.greenCard;
        this.model.gameStarted = true;
      }
    }
  }

}
