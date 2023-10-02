export default class Helpers{

    empty(data){
        if(data==null || data == '' || data=='undefined' || data==undefined || data==0 || data==false ){
            return true;
        }
        return false;
    }
    isJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
     decodeUnicode(inputString) {
        return inputString.replace(/\\u([0-9a-fA-F]{4})/g, (match, hex) => {
            return String.fromCharCode(parseInt(hex, 16));
        });
    }

}