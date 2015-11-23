import {request} from "./request"

export class Lobby {
  constructor() {
    this.model = {
      connected:false,
      oneTicket:() => this.model.tickets == 1,
      tickets:0
     };
    console.log('created lobby');
    rivets.bind($('#lobby'), this.model);
    this.connect();
  }

  getTickets() {
    P.coroutine(function *(self){
      const tickets = yield request({url:'api/lobby/tickets'});
      console.log(tickets);
      this.model.tickets = tickets.tickets;
    }).bind(this)();
  }

  connect() {
    const host = location.host.split(':')[0];
    const ws = new WebSocket(`ws://${host}:9000`);

    ws.onclose = (event) => console.log('closed connection', event);
    ws.onopen = (event) => {
      console.log('opened', event);
      this.model.connected = true;
      ws.send(JSON.stringify({
        'method':'join',
        'channel':'lobby'
      }));

      // ws.close();
    }
    ws.onmessage = (e) => {
      console.log('message', e);
      const data = JSON.parse(e.data);
      if (data.method == 'lobby:updated') {
        this.getTickets();
      } else if (data.method == 'lobby:myTicket') {
        console.log('my ticket', data.ticket);
        this.model.ticket = data.ticket;
      }
    }.bind(this);



  }
}
