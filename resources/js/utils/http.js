import axios from "axios";

const host = window.location.protocol + "//" + window.location.host;
const base_url = `${host}/api/`;
const token = localStorage.getItem('access_token');
const http = axios.create({
  baseURL: base_url,
  headers: {
      "Content-Type": 'application/json',
      "Accept": 'application/json',
      "Authorization": 'Bearer ' + token,
  },
  withCredentials: true,
});

http
  .interceptors
  .response
  .use(
    (response) => response.data,
    (error) => {
      var data = error.response.data;
      var status = error.response.status;

      switch (status) {
          case 401:
            localStorage.removeItem('access_token');
            window.location.replace('/');
            break;

          case 403:
            localStorage.removeItem('access_token');
            window.location.replace('/');
            break;

          default:
            break;
      }

      return Promise.reject(data);
    }
  );

const setToken = (token) => {
  http.defaults.headers.Authorization = "Bearer " + token;
}

const removeToken = () => {
  http.defaults.headers.Authorization = "Bearer ";
}

const httpParam = {
  toFormDataArray: (key, object) => {
      var obj = {};
      for(var oKey in object){
          obj[`${key}[${oKey}]`] = object[oKey];
      }
      return obj;
  },
  isObject: (object) => {
      if(!(object instanceof Object) || object instanceof File){
          return false
      }else{
          return true;
      }

  },
  extract: (object) => {
      var results = {}, tempObject = {};

      var status = 0;
      while(status < 1){
          switch(status){
              case 0:
                  tempObject = object;
                  break;
              default:
                  tempObject = results;
          }
          results = {};
          for (var key in tempObject) {
              for (var k in tempObject[key]) {
                  status = !httpParam.isObject(tempObject[key][k]);
                  results[k] = tempObject[key][k];
              }
          }
      }

      return results;
  },
  toFormDataFormatter: (object) => {

      var results = {},
          obj = {},
          oKey = 'tfdf_key',
          oVal = 'tfdf_val';

      if(object.hasOwnProperty(oKey) && object.hasOwnProperty(oVal)){
          var i =0;
          for(var objectKey in object[oVal]){
              var key =  `${object[oKey]}[${objectKey}]`;
              if(!(object[oVal][objectKey] instanceof Object) || object[oVal][objectKey] instanceof File){
                  obj[key] = object[oVal][objectKey];
                  results = obj;
              }else{
                  obj[oKey] = key;
                  obj[oVal] = object[oVal][objectKey];
                  results[obj[oKey]] = httpParam.toFormDataFormatter(obj)
              }
              i++;
          }
      }else{
          /*
              Format Equipment
              Desc : .....
          */
          var i = 0;
          for( var objectKey in object){
              obj[oKey] = objectKey;
              obj[oVal] = object[objectKey];
              results[objectKey] = httpParam.toFormDataFormatter(obj)
              i++;
          }
      }

      return results;
  },
  toFormData: (object) => {
      var formData = new FormData();
      for(var key in object){
          if(object[key] == null) continue;
          if(object[key] instanceof Array){
              object[key].forEach(function(item){
                  formData.append(`${key}[]`, item);
              })
          }else{
              formData.append(key, object[key]);
          }
      }
      return formData;
  },
  toFormDataPut: (object) => {
      object._method = 'PUT';
      return httpParam.toFormData(object);
  },
  toPut: (object) => {
      object._method = 'PUT';
      return object;
  },
  url: (url, params) => {
      var parameters = (params) ? new URLSearchParams(params).toString() : '';
      parameters = (parameters) ? `?${parameters}` : '';
      parameters = parameters.replaceAll('null','');
      return `${base_url}${url}${parameters}`;
  },
  base64Encode: (data) => {
        //  discuss at: http://phpjs.org/functions/base64_encode/
        // original by: Tyler Akins (http://rumkin.com)
        // improved by: Bayron Guevara
        // improved by: Thunder.m
        // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // improved by: Rafal Kukawski (http://kukawski.pl)
        // bugfixed by: Pellentesque Malesuada
        //   example 1: base64_encode('Kevin van Zonneveld');
        //   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
        //   example 2: base64_encode('a');
        //   returns 2: 'YQ=='

        var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
        var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        enc = '',
        tmp_arr = [];

        if (!data) {
            return data;
        }

        do { // pack three octets into four hexets
            o1 = data.charCodeAt(i++);
            o2 = data.charCodeAt(i++);
            o3 = data.charCodeAt(i++);

            bits = o1 << 16 | o2 << 8 | o3;

            h1 = bits >> 18 & 0x3f;
            h2 = bits >> 12 & 0x3f;
            h3 = bits >> 6 & 0x3f;
            h4 = bits & 0x3f;

            // use hexets to index into b64, and append result to encoded string
            tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
        } while (i < data.length);

        enc = tmp_arr.join('');

        var r = data.length % 3;

        return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
 }
}

const httpOpen = function(path, params, method, newTab) {
    method = method || "get"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", base_url+path);

    if(newTab == 'Y')
    form.setAttribute("target", '_blank');

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}

export default http
export { http, setToken, removeToken, httpParam, httpOpen }
