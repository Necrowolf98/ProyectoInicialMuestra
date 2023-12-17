import 'element-ui/lib/theme-chalk/index.css';
import { Button, Notification, Message, MessageBox } from 'element-ui';
import Vue from "vue";

Vue.use(Button);
Vue.prototype.$notify = Notification;
Vue.prototype.$message = Message;
Vue.prototype.$msgbox = MessageBox;
Vue.prototype.$alert = MessageBox.alert;
Vue.prototype.$confirm = MessageBox.confirm;
Vue.prototype.$prompt = MessageBox.prompt;