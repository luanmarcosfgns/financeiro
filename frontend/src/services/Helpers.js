export default class Helpers{

    empty(data){
        if(data==null || data == '' || data=='undefined' || data==undefined || data==0 || data==false ){
            return true;
        }
        return false;
    }
}