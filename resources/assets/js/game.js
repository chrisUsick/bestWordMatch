import {request} from "./request"

export class Game {
  constructor () {
    this.model = {};
    this.gameId = location.pathname.match(/\d+/)[0];
    this.playerId = localStorage.getItem('ticket');

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

      if (data.method == 'game:myHand') {
        this.model.myHand = data.cards;
        console.log('my hand', data.cards);
      }
    }.bind(this);
  }

}
