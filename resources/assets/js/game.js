import {request} from "./request"

export class Game {
  constructor () {
    this.model = {
      showWaitingMsg: () => !this.model.gameStarted || this.model.registrationError,
      playCard: this.playCard.bind(this)
    };
    this.gameId = location.pathname.match(/\d+/)[0];
    this.playerId = localStorage.getItem('ticket');
    this.model.playerId = this.playerId;
    this.messageHandler = this.getMessageHandler();
    rivets.bind($("#app"), this.model);

    this.initWebSocket();
  }

  playCard (ev, context) {
    console.log();
    const card = context.card;
    const data = {
      method: 'game:playCard',
      gameId:this.gameId,
      playerId: this.playerId,
      card: JSON.stringify(card)
    }
    this.ws.send(JSON.stringify(data));
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
        this.model.judge = data.judge;
        this.model.players = this.setPlayers(data.players, data.judge);
        this.model.gameStarted = true;
      }

      , 'game:unknownError': (data) => console.log("unknown error: ", data.message)
    }
  }

  setPlayers(players, judge) {
    return players.map((p) => {return {name:p, judge:(p == judge)}});
  }

}
