(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _request = require("./request");

var Lobby = (function () {
  function Lobby() {
    _classCallCheck(this, Lobby);

    console.log('created lobby');
  }

  _createClass(Lobby, [{
    key: 'join',
    value: function join() {
      P.coroutine(regeneratorRuntime.mark(function callee$2$0() {
        var data, tickets;
        return regeneratorRuntime.wrap(function callee$2$0$(context$3$0) {
          while (1) switch (context$3$0.prev = context$3$0.next) {
            case 0:
              context$3$0.prev = 0;
              context$3$0.next = 3;
              return (0, _request.request)({ url: 'api/lobby/join' });

            case 3:
              data = context$3$0.sent;

              console.log('my ticket', data);
              context$3$0.next = 7;
              return (0, _request.request)({ url: 'api/lobby/tickets' });

            case 7:
              tickets = context$3$0.sent;

              console.log('number of tickets', tickets);
              context$3$0.next = 14;
              break;

            case 11:
              context$3$0.prev = 11;
              context$3$0.t0 = context$3$0['catch'](0);

              console.log('error', context$3$0.t0);

            case 14:
            case 'end':
              return context$3$0.stop();
          }
        }, callee$2$0, this, [[0, 11]]);
      }))();
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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9sYXJhdmVsLWVsaXhpci9ub2RlX21vZHVsZXMvYnJvd3NlcmlmeS9ub2RlX21vZHVsZXMvYnJvd3Nlci1wYWNrL19wcmVsdWRlLmpzIiwiQzovVXNlcnMvY2hyaXMvcC9iZXN0V29yZE1hdGNoL3Jlc291cmNlcy9hc3NldHMvanMvbG9iYnkuanMiLCJDOi9Vc2Vycy9jaHJpcy9wL2Jlc3RXb3JkTWF0Y2gvcmVzb3VyY2VzL2Fzc2V0cy9qcy9yZXF1ZXN0LmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7O3VCQ0FzQixXQUFXOztJQUUzQixLQUFLO0FBQ0UsV0FEUCxLQUFLLEdBQ0s7MEJBRFYsS0FBSzs7QUFFUCxXQUFPLENBQUMsR0FBRyxDQUFDLGVBQWUsQ0FBQyxDQUFDO0dBQzlCOztlQUhHLEtBQUs7O1dBSUwsZ0JBQUc7QUFDTCxPQUFDLENBQUMsU0FBUyx5QkFBQztZQUVGLElBQUksRUFFSixPQUFPOzs7Ozs7cUJBRk0sc0JBQVEsRUFBQyxHQUFHLEVBQUMsZ0JBQWdCLEVBQUMsQ0FBQzs7O0FBQTVDLGtCQUFJOztBQUNWLHFCQUFPLENBQUMsR0FBRyxDQUFDLFdBQVcsRUFBRSxJQUFJLENBQUMsQ0FBQzs7cUJBQ1Qsc0JBQVEsRUFBQyxHQUFHLEVBQUMsbUJBQW1CLEVBQUMsQ0FBQzs7O0FBQWxELHFCQUFPOztBQUNiLHFCQUFPLENBQUMsR0FBRyxDQUFDLG1CQUFtQixFQUFFLE9BQU8sQ0FBQyxDQUFDOzs7Ozs7OztBQUUxQyxxQkFBTyxDQUFDLEdBQUcsQ0FBQyxPQUFPLGlCQUFJLENBQUM7Ozs7Ozs7T0FFM0IsRUFBQyxFQUFFLENBQUM7S0FDTjs7O1NBZkcsS0FBSzs7O0FBa0JYLElBQU0sQ0FBQyxHQUFHLElBQUksS0FBSyxFQUFFLENBQUM7O0FBRXRCLENBQUMsQ0FBQyxJQUFJLEVBQUUsQ0FBQzs7Ozs7Ozs7OztBQ3RCRixTQUFTLE9BQU8sQ0FBRSxJQUFxQixFQUFFO29CQUF2QixJQUFxQixDQUFwQixNQUFNO01BQU4sTUFBTSwrQkFBRyxLQUFLO01BQUUsR0FBRyxHQUFwQixJQUFxQixDQUFKLEdBQUc7O0FBQzNDLE1BQUksR0FBRyxHQUFHLElBQUksY0FBYyxFQUFFLENBQUM7QUFDL0IsU0FBTyxJQUFJLENBQUMsQ0FBQyxVQUFDLE9BQU8sRUFBRSxNQUFNLEVBQUs7QUFDaEMsT0FBRyxDQUFDLElBQUksQ0FBQyxNQUFNLEVBQUUsR0FBRyxDQUFDLENBQUM7QUFDdEIsT0FBRyxDQUFDLGtCQUFrQixHQUFHLFlBQU07QUFDN0IsVUFBSSxHQUFHLENBQUMsVUFBVSxJQUFJLENBQUMsSUFBSSxHQUFHLENBQUMsTUFBTSxJQUFJLEdBQUcsRUFBQztBQUMzQyxlQUFPLENBQUMsSUFBSSxDQUFDLEtBQUssQ0FBQyxHQUFHLENBQUMsWUFBWSxDQUFDLENBQUMsQ0FBQztPQUN2QyxNQUFNLElBQUksR0FBRyxDQUFDLFVBQVUsSUFBSSxDQUFDLEVBQUM7QUFDN0IsY0FBTSxDQUFDLEdBQUcsQ0FBQyxDQUFDO09BQ2I7S0FDRixDQUFBO0FBQ0QsT0FBRyxDQUFDLElBQUksRUFBRSxDQUFDO0dBQ1osQ0FBQyxDQUFDO0NBQ0oiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiBlKHQsbixyKXtmdW5jdGlvbiBzKG8sdSl7aWYoIW5bb10pe2lmKCF0W29dKXt2YXIgYT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2lmKCF1JiZhKXJldHVybiBhKG8sITApO2lmKGkpcmV0dXJuIGkobywhMCk7dmFyIGY9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitvK1wiJ1wiKTt0aHJvdyBmLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsZn12YXIgbD1uW29dPXtleHBvcnRzOnt9fTt0W29dWzBdLmNhbGwobC5leHBvcnRzLGZ1bmN0aW9uKGUpe3ZhciBuPXRbb11bMV1bZV07cmV0dXJuIHMobj9uOmUpfSxsLGwuZXhwb3J0cyxlLHQsbixyKX1yZXR1cm4gbltvXS5leHBvcnRzfXZhciBpPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7Zm9yKHZhciBvPTA7bzxyLmxlbmd0aDtvKyspcyhyW29dKTtyZXR1cm4gc30pIiwiaW1wb3J0IHtyZXF1ZXN0fSBmcm9tIFwiLi9yZXF1ZXN0XCJcclxuXHJcbmNsYXNzIExvYmJ5IHtcclxuICBjb25zdHJ1Y3RvcigpIHtcclxuICAgIGNvbnNvbGUubG9nKCdjcmVhdGVkIGxvYmJ5Jyk7XHJcbiAgfVxyXG4gIGpvaW4oKSB7XHJcbiAgICBQLmNvcm91dGluZShmdW5jdGlvbiAqKCkge1xyXG4gICAgICB0cnl7XHJcbiAgICAgICAgY29uc3QgZGF0YSA9IHlpZWxkIHJlcXVlc3Qoe3VybDonYXBpL2xvYmJ5L2pvaW4nfSk7XHJcbiAgICAgICAgY29uc29sZS5sb2coJ215IHRpY2tldCcsIGRhdGEpO1xyXG4gICAgICAgIGNvbnN0IHRpY2tldHMgPSB5aWVsZCByZXF1ZXN0KHt1cmw6J2FwaS9sb2JieS90aWNrZXRzJ30pO1xyXG4gICAgICAgIGNvbnNvbGUubG9nKCdudW1iZXIgb2YgdGlja2V0cycsIHRpY2tldHMpO1xyXG4gICAgICB9IGNhdGNoIChlKSB7XHJcbiAgICAgICAgY29uc29sZS5sb2coJ2Vycm9yJywgZSk7XHJcbiAgICAgIH1cclxuICAgIH0pKCk7XHJcbiAgfVxyXG59XHJcblxyXG5jb25zdCBhID0gbmV3IExvYmJ5KCk7XHJcblxyXG5hLmpvaW4oKTtcclxuIiwiZXhwb3J0IGZ1bmN0aW9uIHJlcXVlc3QgKHttZXRob2QgPSAnR0VUJywgdXJsfSkge1xyXG4gIGxldCByZXEgPSBuZXcgWE1MSHR0cFJlcXVlc3QoKTtcclxuICByZXR1cm4gbmV3IFAoKHJlc29sdmUsIHJlamVjdCkgPT4ge1xyXG4gICAgcmVxLm9wZW4obWV0aG9kLCB1cmwpO1xyXG4gICAgcmVxLm9ucmVhZHlzdGF0ZWNoYW5nZSA9ICgpID0+IHtcclxuICAgICAgaWYgKHJlcS5yZWFkeVN0YXRlID09IDQgJiYgcmVxLnN0YXR1cyA9PSAyMDApe1xyXG4gICAgICAgIHJlc29sdmUoSlNPTi5wYXJzZShyZXEucmVzcG9uc2VUZXh0KSk7XHJcbiAgICAgIH0gZWxzZSBpZiAocmVxLnJlYWR5U3RhdGUgPT0gNCl7XHJcbiAgICAgICAgcmVqZWN0KHJlcSk7XHJcbiAgICAgIH1cclxuICAgIH1cclxuICAgIHJlcS5zZW5kKCk7XHJcbiAgfSk7XHJcbn1cclxuIl19
