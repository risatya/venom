/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function getBaseURL() {
    var url = location.href;  // entire url including querystring - also: window.location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));


    if (baseURL.indexOf('http://smartdesainer.com') != -1) {
        // Base Url for localhost
        var url = location.href;  // window.location.href;
        var pathname = location.pathname;  // window.location.pathname;
        var index1 = url.indexOf(pathname);
        var index2 = url.indexOf("/", index1 + 1);
        var baseLocalUrl = url.substr(0, index2);

         return "http://smartdesainer.com/creativepro/";
    }
    else {
        // Root Url for domain name
//        return "http://www.localhost/prudential/";
          return "http://smartdesainer.com/creativepro/";
    }

}



