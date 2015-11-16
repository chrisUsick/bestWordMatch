(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _request = require("./request");

var Lobby = (function () {
  function Lobby() {
    _classCallCheck(this, Lobby);

    console.log('created lobby');
    rivets.bind($('#app', { connected: false }));
  }

  _createClass(Lobby, [{
    key: 'join',
    value: function join() {
      this.connect();
      // let self = this;
      // P.coroutine(function *() {
      //   try{
      //     // const data = yield request({url:'api/lobby/join'});
      //     console.log('my ticket', data);
      //     self.ticket = data.ticket;
      //     // const tickets = yield request({url:'api/lobby/tickets'});
      //     // console.log('number of tickets', tickets);
      //     self.connect();
      //   } catch (e) {
      //     console.log('error', e);
      //   }
      // })();
    }
  }, {
    key: 'getTickets',
    value: function getTickets() {
      P.coroutine(regeneratorRuntime.mark(function callee$2$0(self) {
        var tickets;
        return regeneratorRuntime.wrap(function callee$2$0$(context$3$0) {
          while (1) switch (context$3$0.prev = context$3$0.next) {
            case 0:
              context$3$0.next = 2;
              return (0, _request.request)({ url: 'api/lobby/tickets' });

            case 2:
              tickets = context$3$0.sent;

              console.log(tickets);

            case 4:
            case 'end':
              return context$3$0.stop();
          }
        }, callee$2$0, this);
      }))(this);
    }
  }, {
    key: 'connect',
    value: function connect() {
      var _this = this;

      var ws = new WebSocket('ws://b.localhost:9000');

      ws.onclose = function (event) {
        return console.log('closed connection', event);
      };
      ws.onopen = function (event) {
        console.log('opened', event);
      };
      ws.onmessage = (function (e) {
        console.log('message', e);
        var data = JSON.parse(e.data);
        if (data.method == 'lobby:updated') {
          _this.getTickets();
        } else if (data.method == 'lobby:myTicket') {
          console.log('my ticket', data.ticket);
        }
      }).bind(this);
    }
  }]);

  return Lobby;
})();

var a = new Lobby();

a.join();

},{"./request":2}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, '__esModule', {
  value: true
});
exports.request = request;

function request(_ref) {
  var _ref$method = _ref.method;
  var method = _ref$method === undefined ? 'GET' : _ref$method;
  var url = _ref.url;

  var req = new XMLHttpRequest();
  return new P(function (resolve, reject) {
    req.open(method, url);
    req.onreadystatechange = function () {
      if (req.readyState == 4 && req.status == 200) {
        resolve(JSON.parse(req.responseText));
      } else if (req.readyState == 4) {
        reject(req);
      }
    };
    req.send();
  });
}

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9sYXJhdmVsLWVsaXhpci9ub2RlX21vZHVsZXMvYnJvd3NlcmlmeS9ub2RlX21vZHVsZXMvYnJvd3Nlci1wYWNrL19wcmVsdWRlLmpzIiwiQzovVXNlcnMvY2hyaXMvcC9iZXN0V29yZE1hdGNoL3Jlc291cmNlcy9hc3NldHMvanMvbG9iYnkuanMiLCJDOi9Vc2Vycy9jaHJpcy9wL2Jlc3RXb3JkTWF0Y2gvcmVzb3VyY2VzL2Fzc2V0cy9qcy9yZXF1ZXN0LmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7O3VCQ0FzQixXQUFXOztJQUUzQixLQUFLO0FBQ0UsV0FEUCxLQUFLLEdBQ0s7MEJBRFYsS0FBSzs7QUFFUCxXQUFPLENBQUMsR0FBRyxDQUFDLGVBQWUsQ0FBQyxDQUFDO0FBQzdCLFVBQU0sQ0FBQyxJQUFJLENBQUMsQ0FBQyxDQUFDLE1BQU0sRUFBRSxFQUFDLFNBQVMsRUFBQyxLQUFLLEVBQUMsQ0FBQyxDQUFDLENBQUM7R0FDM0M7O2VBSkcsS0FBSzs7V0FLTCxnQkFBRztBQUNMLFVBQUksQ0FBQyxPQUFPLEVBQUUsQ0FBQzs7Ozs7Ozs7Ozs7Ozs7S0FjaEI7OztXQUVTLHNCQUFHO0FBQ1gsT0FBQyxDQUFDLFNBQVMseUJBQUMsb0JBQVcsSUFBSTtZQUNuQixPQUFPOzs7OztxQkFBUyxzQkFBUSxFQUFDLEdBQUcsRUFBQyxtQkFBbUIsRUFBQyxDQUFDOzs7QUFBbEQscUJBQU87O0FBQ2IscUJBQU8sQ0FBQyxHQUFHLENBQUMsT0FBTyxDQUFDLENBQUM7Ozs7Ozs7T0FDdEIsRUFBQyxDQUFDLElBQUksQ0FBQyxDQUFDO0tBQ1Y7OztXQUVNLG1CQUFHOzs7QUFDUixVQUFNLEVBQUUsR0FBRyxJQUFJLFNBQVMsQ0FBQyx1QkFBdUIsQ0FBQyxDQUFDOztBQUVsRCxRQUFFLENBQUMsT0FBTyxHQUFHLFVBQUMsS0FBSztlQUFLLE9BQU8sQ0FBQyxHQUFHLENBQUMsbUJBQW1CLEVBQUUsS0FBSyxDQUFDO09BQUEsQ0FBQztBQUNoRSxRQUFFLENBQUMsTUFBTSxHQUFHLFVBQUMsS0FBSyxFQUFLO0FBQ3JCLGVBQU8sQ0FBQyxHQUFHLENBQUMsUUFBUSxFQUFFLEtBQUssQ0FBQyxDQUFDO09BQzlCLENBQUE7QUFDRCxRQUFFLENBQUMsU0FBUyxHQUFHLENBQUEsVUFBQyxDQUFDLEVBQUs7QUFDcEIsZUFBTyxDQUFDLEdBQUcsQ0FBQyxTQUFTLEVBQUUsQ0FBQyxDQUFDLENBQUM7QUFDMUIsWUFBTSxJQUFJLEdBQUcsSUFBSSxDQUFDLEtBQUssQ0FBQyxDQUFDLENBQUMsSUFBSSxDQUFDLENBQUM7QUFDaEMsWUFBSSxJQUFJLENBQUMsTUFBTSxJQUFJLGVBQWUsRUFBRTtBQUNsQyxnQkFBSyxVQUFVLEVBQUUsQ0FBQztTQUNuQixNQUFNLElBQUksSUFBSSxDQUFDLE1BQU0sSUFBSSxnQkFBZ0IsRUFBRTtBQUMxQyxpQkFBTyxDQUFDLEdBQUcsQ0FBQyxXQUFXLEVBQUUsSUFBSSxDQUFDLE1BQU0sQ0FBQyxDQUFDO1NBQ3ZDO09BQ0YsQ0FBQSxDQUFDLElBQUksQ0FBQyxJQUFJLENBQUMsQ0FBQztLQUVkOzs7U0E5Q0csS0FBSzs7O0FBaURYLElBQU0sQ0FBQyxHQUFHLElBQUksS0FBSyxFQUFFLENBQUM7O0FBRXRCLENBQUMsQ0FBQyxJQUFJLEVBQUUsQ0FBQzs7Ozs7Ozs7OztBQ3JERixTQUFTLE9BQU8sQ0FBRSxJQUFxQixFQUFFO29CQUF2QixJQUFxQixDQUFwQixNQUFNO01BQU4sTUFBTSwrQkFBRyxLQUFLO01BQUUsR0FBRyxHQUFwQixJQUFxQixDQUFKLEdBQUc7O0FBQzNDLE1BQUksR0FBRyxHQUFHLElBQUksY0FBYyxFQUFFLENBQUM7QUFDL0IsU0FBTyxJQUFJLENBQUMsQ0FBQyxVQUFDLE9BQU8sRUFBRSxNQUFNLEVBQUs7QUFDaEMsT0FBRyxDQUFDLElBQUksQ0FBQyxNQUFNLEVBQUUsR0FBRyxDQUFDLENBQUM7QUFDdEIsT0FBRyxDQUFDLGtCQUFrQixHQUFHLFlBQU07QUFDN0IsVUFBSSxHQUFHLENBQUMsVUFBVSxJQUFJLENBQUMsSUFBSSxHQUFHLENBQUMsTUFBTSxJQUFJLEdBQUcsRUFBQztBQUMzQyxlQUFPLENBQUMsSUFBSSxDQUFDLEtBQUssQ0FBQyxHQUFHLENBQUMsWUFBWSxDQUFDLENBQUMsQ0FBQztPQUN2QyxNQUFNLElBQUksR0FBRyxDQUFDLFVBQVUsSUFBSSxDQUFDLEVBQUM7QUFDN0IsY0FBTSxDQUFDLEdBQUcsQ0FBQyxDQUFDO09BQ2I7S0FDRixDQUFBO0FBQ0QsT0FBRyxDQUFDLElBQUksRUFBRSxDQUFDO0dBQ1osQ0FBQyxDQUFDO0NBQ0oiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiBlKHQsbixyKXtmdW5jdGlvbiBzKG8sdSl7aWYoIW5bb10pe2lmKCF0W29dKXt2YXIgYT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2lmKCF1JiZhKXJldHVybiBhKG8sITApO2lmKGkpcmV0dXJuIGkobywhMCk7dmFyIGY9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitvK1wiJ1wiKTt0aHJvdyBmLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsZn12YXIgbD1uW29dPXtleHBvcnRzOnt9fTt0W29dWzBdLmNhbGwobC5leHBvcnRzLGZ1bmN0aW9uKGUpe3ZhciBuPXRbb11bMV1bZV07cmV0dXJuIHMobj9uOmUpfSxsLGwuZXhwb3J0cyxlLHQsbixyKX1yZXR1cm4gbltvXS5leHBvcnRzfXZhciBpPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7Zm9yKHZhciBvPTA7bzxyLmxlbmd0aDtvKyspcyhyW29dKTtyZXR1cm4gc30pIiwiaW1wb3J0IHtyZXF1ZXN0fSBmcm9tIFwiLi9yZXF1ZXN0XCJcclxuXHJcbmNsYXNzIExvYmJ5IHtcclxuICBjb25zdHJ1Y3RvcigpIHtcclxuICAgIGNvbnNvbGUubG9nKCdjcmVhdGVkIGxvYmJ5Jyk7XHJcbiAgICByaXZldHMuYmluZCgkKCcjYXBwJywge2Nvbm5lY3RlZDpmYWxzZX0pKTtcclxuICB9XHJcbiAgam9pbigpIHtcclxuICAgIHRoaXMuY29ubmVjdCgpO1xyXG4gICAgLy8gbGV0IHNlbGYgPSB0aGlzO1xyXG4gICAgLy8gUC5jb3JvdXRpbmUoZnVuY3Rpb24gKigpIHtcclxuICAgIC8vICAgdHJ5e1xyXG4gICAgLy8gICAgIC8vIGNvbnN0IGRhdGEgPSB5aWVsZCByZXF1ZXN0KHt1cmw6J2FwaS9sb2JieS9qb2luJ30pO1xyXG4gICAgLy8gICAgIGNvbnNvbGUubG9nKCdteSB0aWNrZXQnLCBkYXRhKTtcclxuICAgIC8vICAgICBzZWxmLnRpY2tldCA9IGRhdGEudGlja2V0O1xyXG4gICAgLy8gICAgIC8vIGNvbnN0IHRpY2tldHMgPSB5aWVsZCByZXF1ZXN0KHt1cmw6J2FwaS9sb2JieS90aWNrZXRzJ30pO1xyXG4gICAgLy8gICAgIC8vIGNvbnNvbGUubG9nKCdudW1iZXIgb2YgdGlja2V0cycsIHRpY2tldHMpO1xyXG4gICAgLy8gICAgIHNlbGYuY29ubmVjdCgpO1xyXG4gICAgLy8gICB9IGNhdGNoIChlKSB7XHJcbiAgICAvLyAgICAgY29uc29sZS5sb2coJ2Vycm9yJywgZSk7XHJcbiAgICAvLyAgIH1cclxuICAgIC8vIH0pKCk7XHJcbiAgfVxyXG5cclxuICBnZXRUaWNrZXRzKCkge1xyXG4gICAgUC5jb3JvdXRpbmUoZnVuY3Rpb24gKihzZWxmKXtcclxuICAgICAgY29uc3QgdGlja2V0cyA9IHlpZWxkIHJlcXVlc3Qoe3VybDonYXBpL2xvYmJ5L3RpY2tldHMnfSk7XHJcbiAgICAgIGNvbnNvbGUubG9nKHRpY2tldHMpO1xyXG4gICAgfSkodGhpcyk7XHJcbiAgfVxyXG5cclxuICBjb25uZWN0KCkge1xyXG4gICAgY29uc3Qgd3MgPSBuZXcgV2ViU29ja2V0KCd3czovL2IubG9jYWxob3N0OjkwMDAnKTtcclxuXHJcbiAgICB3cy5vbmNsb3NlID0gKGV2ZW50KSA9PiBjb25zb2xlLmxvZygnY2xvc2VkIGNvbm5lY3Rpb24nLCBldmVudCk7XHJcbiAgICB3cy5vbm9wZW4gPSAoZXZlbnQpID0+IHtcclxuICAgICAgY29uc29sZS5sb2coJ29wZW5lZCcsIGV2ZW50KTtcclxuICAgIH1cclxuICAgIHdzLm9ubWVzc2FnZSA9IChlKSA9PiB7XHJcbiAgICAgIGNvbnNvbGUubG9nKCdtZXNzYWdlJywgZSk7XHJcbiAgICAgIGNvbnN0IGRhdGEgPSBKU09OLnBhcnNlKGUuZGF0YSk7XHJcbiAgICAgIGlmIChkYXRhLm1ldGhvZCA9PSAnbG9iYnk6dXBkYXRlZCcpIHtcclxuICAgICAgICB0aGlzLmdldFRpY2tldHMoKTtcclxuICAgICAgfSBlbHNlIGlmIChkYXRhLm1ldGhvZCA9PSAnbG9iYnk6bXlUaWNrZXQnKSB7XHJcbiAgICAgICAgY29uc29sZS5sb2coJ215IHRpY2tldCcsIGRhdGEudGlja2V0KTtcclxuICAgICAgfVxyXG4gICAgfS5iaW5kKHRoaXMpO1xyXG5cclxuICB9XHJcbn1cclxuXHJcbmNvbnN0IGEgPSBuZXcgTG9iYnkoKTtcclxuXHJcbmEuam9pbigpO1xyXG4iLCJleHBvcnQgZnVuY3Rpb24gcmVxdWVzdCAoe21ldGhvZCA9ICdHRVQnLCB1cmx9KSB7XHJcbiAgbGV0IHJlcSA9IG5ldyBYTUxIdHRwUmVxdWVzdCgpO1xyXG4gIHJldHVybiBuZXcgUCgocmVzb2x2ZSwgcmVqZWN0KSA9PiB7XHJcbiAgICByZXEub3BlbihtZXRob2QsIHVybCk7XHJcbiAgICByZXEub25yZWFkeXN0YXRlY2hhbmdlID0gKCkgPT4ge1xyXG4gICAgICBpZiAocmVxLnJlYWR5U3RhdGUgPT0gNCAmJiByZXEuc3RhdHVzID09IDIwMCl7XHJcbiAgICAgICAgcmVzb2x2ZShKU09OLnBhcnNlKHJlcS5yZXNwb25zZVRleHQpKTtcclxuICAgICAgfSBlbHNlIGlmIChyZXEucmVhZHlTdGF0ZSA9PSA0KXtcclxuICAgICAgICByZWplY3QocmVxKTtcclxuICAgICAgfVxyXG4gICAgfVxyXG4gICAgcmVxLnNlbmQoKTtcclxuICB9KTtcclxufVxyXG4iXX0=
