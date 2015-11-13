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
        var data;
        return regeneratorRuntime.wrap(function callee$2$0$(context$3$0) {
          while (1) switch (context$3$0.prev = context$3$0.next) {
            case 0:
              context$3$0.prev = 0;
              context$3$0.next = 3;
              return (0, _request.request)({ url: 'api/lobby/join' });

            case 3:
              data = context$3$0.sent;

              console.log(data);
              context$3$0.next = 10;
              break;

            case 7:
              context$3$0.prev = 7;
              context$3$0.t0 = context$3$0['catch'](0);

              console.log('error', context$3$0.t0);

            case 10:
            case 'end':
              return context$3$0.stop();
          }
        }, callee$2$0, this, [[0, 7]]);
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
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9sYXJhdmVsLWVsaXhpci9ub2RlX21vZHVsZXMvYnJvd3NlcmlmeS9ub2RlX21vZHVsZXMvYnJvd3Nlci1wYWNrL19wcmVsdWRlLmpzIiwiQzovVXNlcnMvY2hyaXMvcC9iZXN0V29yZE1hdGNoL3Jlc291cmNlcy9hc3NldHMvanMvbG9iYnkuanMiLCJDOi9Vc2Vycy9jaHJpcy9wL2Jlc3RXb3JkTWF0Y2gvcmVzb3VyY2VzL2Fzc2V0cy9qcy9yZXF1ZXN0LmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7O3VCQ0FzQixXQUFXOztJQUUzQixLQUFLO0FBQ0UsV0FEUCxLQUFLLEdBQ0s7MEJBRFYsS0FBSzs7QUFFUCxXQUFPLENBQUMsR0FBRyxDQUFDLGVBQWUsQ0FBQyxDQUFDO0dBQzlCOztlQUhHLEtBQUs7O1dBSUwsZ0JBQUc7QUFDTCxPQUFDLENBQUMsU0FBUyx5QkFBQztZQUVGLElBQUk7Ozs7OztxQkFBUyxzQkFBUSxFQUFDLEdBQUcsRUFBQyxnQkFBZ0IsRUFBQyxDQUFDOzs7QUFBNUMsa0JBQUk7O0FBQ1YscUJBQU8sQ0FBQyxHQUFHLENBQUMsSUFBSSxDQUFDLENBQUM7Ozs7Ozs7O0FBRWxCLHFCQUFPLENBQUMsR0FBRyxDQUFDLE9BQU8saUJBQUksQ0FBQzs7Ozs7OztPQUUzQixFQUFDLEVBQUUsQ0FBQztLQUNOOzs7U0FiRyxLQUFLOzs7QUFnQlgsSUFBTSxDQUFDLEdBQUcsSUFBSSxLQUFLLEVBQUUsQ0FBQzs7QUFFdEIsQ0FBQyxDQUFDLElBQUksRUFBRSxDQUFDOzs7Ozs7Ozs7O0FDcEJGLFNBQVMsT0FBTyxDQUFFLElBQXFCLEVBQUU7b0JBQXZCLElBQXFCLENBQXBCLE1BQU07TUFBTixNQUFNLCtCQUFHLEtBQUs7TUFBRSxHQUFHLEdBQXBCLElBQXFCLENBQUosR0FBRzs7QUFDM0MsTUFBSSxHQUFHLEdBQUcsSUFBSSxjQUFjLEVBQUUsQ0FBQztBQUMvQixTQUFPLElBQUksQ0FBQyxDQUFDLFVBQUMsT0FBTyxFQUFFLE1BQU0sRUFBSztBQUNoQyxPQUFHLENBQUMsSUFBSSxDQUFDLE1BQU0sRUFBRSxHQUFHLENBQUMsQ0FBQztBQUN0QixPQUFHLENBQUMsa0JBQWtCLEdBQUcsWUFBTTtBQUM3QixVQUFJLEdBQUcsQ0FBQyxVQUFVLElBQUksQ0FBQyxJQUFJLEdBQUcsQ0FBQyxNQUFNLElBQUksR0FBRyxFQUFDO0FBQzNDLGVBQU8sQ0FBQyxJQUFJLENBQUMsS0FBSyxDQUFDLEdBQUcsQ0FBQyxZQUFZLENBQUMsQ0FBQyxDQUFDO09BQ3ZDLE1BQU0sSUFBSSxHQUFHLENBQUMsVUFBVSxJQUFJLENBQUMsRUFBQztBQUM3QixjQUFNLENBQUMsR0FBRyxDQUFDLENBQUM7T0FDYjtLQUNGLENBQUE7QUFDRCxPQUFHLENBQUMsSUFBSSxFQUFFLENBQUM7R0FDWixDQUFDLENBQUM7Q0FDSiIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uIGUodCxuLHIpe2Z1bmN0aW9uIHMobyx1KXtpZighbltvXSl7aWYoIXRbb10pe3ZhciBhPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7aWYoIXUmJmEpcmV0dXJuIGEobywhMCk7aWYoaSlyZXR1cm4gaShvLCEwKTt2YXIgZj1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK28rXCInXCIpO3Rocm93IGYuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixmfXZhciBsPW5bb109e2V4cG9ydHM6e319O3Rbb11bMF0uY2FsbChsLmV4cG9ydHMsZnVuY3Rpb24oZSl7dmFyIG49dFtvXVsxXVtlXTtyZXR1cm4gcyhuP246ZSl9LGwsbC5leHBvcnRzLGUsdCxuLHIpfXJldHVybiBuW29dLmV4cG9ydHN9dmFyIGk9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtmb3IodmFyIG89MDtvPHIubGVuZ3RoO28rKylzKHJbb10pO3JldHVybiBzfSkiLCJpbXBvcnQge3JlcXVlc3R9IGZyb20gXCIuL3JlcXVlc3RcIlxyXG5cclxuY2xhc3MgTG9iYnkge1xyXG4gIGNvbnN0cnVjdG9yKCkge1xyXG4gICAgY29uc29sZS5sb2coJ2NyZWF0ZWQgbG9iYnknKTtcclxuICB9XHJcbiAgam9pbigpIHtcclxuICAgIFAuY29yb3V0aW5lKGZ1bmN0aW9uICooKSB7XHJcbiAgICAgIHRyeXtcclxuICAgICAgICBjb25zdCBkYXRhID0geWllbGQgcmVxdWVzdCh7dXJsOidhcGkvbG9iYnkvam9pbid9KTtcclxuICAgICAgICBjb25zb2xlLmxvZyhkYXRhKTtcclxuICAgICAgfSBjYXRjaCAoZSkge1xyXG4gICAgICAgIGNvbnNvbGUubG9nKCdlcnJvcicsIGUpO1xyXG4gICAgICB9XHJcbiAgICB9KSgpO1xyXG4gIH1cclxufVxyXG5cclxuY29uc3QgYSA9IG5ldyBMb2JieSgpO1xyXG5cclxuYS5qb2luKCk7XHJcbiIsImV4cG9ydCBmdW5jdGlvbiByZXF1ZXN0ICh7bWV0aG9kID0gJ0dFVCcsIHVybH0pIHtcclxuICBsZXQgcmVxID0gbmV3IFhNTEh0dHBSZXF1ZXN0KCk7XHJcbiAgcmV0dXJuIG5ldyBQKChyZXNvbHZlLCByZWplY3QpID0+IHtcclxuICAgIHJlcS5vcGVuKG1ldGhvZCwgdXJsKTtcclxuICAgIHJlcS5vbnJlYWR5c3RhdGVjaGFuZ2UgPSAoKSA9PiB7XHJcbiAgICAgIGlmIChyZXEucmVhZHlTdGF0ZSA9PSA0ICYmIHJlcS5zdGF0dXMgPT0gMjAwKXtcclxuICAgICAgICByZXNvbHZlKEpTT04ucGFyc2UocmVxLnJlc3BvbnNlVGV4dCkpO1xyXG4gICAgICB9IGVsc2UgaWYgKHJlcS5yZWFkeVN0YXRlID09IDQpe1xyXG4gICAgICAgIHJlamVjdChyZXEpO1xyXG4gICAgICB9XHJcbiAgICB9XHJcbiAgICByZXEuc2VuZCgpO1xyXG4gIH0pO1xyXG59XHJcbiJdfQ==
