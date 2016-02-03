/**
 * Created by hieunt on 2/3/16.
 */
var socketString = "ws://127.0.0.1:8889";
const SETJOBID = 1;
function getStatus(status) {
    switch (status) {
        case 0:
            return "waitting";
        case 1:
            return "running";
        case 2:
            return "completed";
    }
}