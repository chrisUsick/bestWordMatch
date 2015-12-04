import {request} from "./request"

export class Game {
  constructor () {
    this.model = {
      showWaitingMsg: () => !this.model.gameStarted && !this.model.registrationError,
      playCard: this.playCard.bind(this),
      pickWinningCard: this.pickWinningCard.bind(this),
      hasPlayed: false
    };
    const urlId = location.pathname.match(/\d+/);
    // set game id
    if (urlId) {
      this.gameId = urlId[0]
    } else if (localStorage.getItem('gameId')) {
      this.gameId = localStorage.getItem('gameId');
    }
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
    if (this.model.judge != this.playerId && !this.model.hasPlayed) {
      this.ws.send(JSON.stringify(data));
      this.model.hasPlayed = true;
    }
  }

  pickWinningCard(ev, context) {
    const card = context.card;
    const data = {
      method:'game:pickWinningCard',
      gameId:this.gameId,
      winningCard: JSON.stringify(card)
    }
    if (this.model.judge == this.playerId) {
      this.ws.send(JSON.stringify(data));
    }
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
      console.log('message', e.data);
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
        if (!this.model.registered) {
          localStorage.setItem('gameId', this.gameId);
        }
        this.model.registered = true;
      }
      , 'game:registrationError': (data) => this.model.registrationError = data.error
      , 'game:roundReady': (data) => {
        this.model.greenCard = data.greenCard;
        this.model.judge = data.judge;
        // this.model.players = this.setPlayers(data.players, data.judge);
        this.model.gameStarted = true;
        this.model.isJudge = data.judge == this.playerId;
        this.setPlayers(data);

        // reset state
        // this.model.playedCards = [];
        this.model.hasPlayed = data.playersPlayed.indexOf(this.playerId) != -1;
      }
      , 'game:playedCards': (data) => {
        this.model.playedCards = data.playedCards;
      }
      , 'game:cardPlayed': (data) => {
        this.setPlayers(data);
      }
      , 'game:unknownError': (data) =>  {
        this.model.registrationError = !this.model.registered ? 'Failed To register' : '';
        console.log("unknown error: ", data.message)
      }
    }
  }

  /**
   * extract the players data into objects and set the player has played property
   */
  setPlayers(data) {
    this.model.players = data.players.map((p) => {
      return {
        name:p,
        judge:(p == data.judge),
        played:(data.playersPlayed && data.playersPlayed.indexOf(p) != -1),
        score:data.playerScores[p] || 0
      }
    });
  }

}
