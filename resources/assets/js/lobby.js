import {request} from "./request"

class Lobby {
  constructor() {
    console.log('created lobby');
  }
  join() {
    P.coroutine(function *() {
      try{
        const data = yield request({url:'api/lobby/join'});
        console.log(data);
      } catch (e) {
        console.log('error', e);
      }
    })();
  }
}

const a = new Lobby();

a.join();
