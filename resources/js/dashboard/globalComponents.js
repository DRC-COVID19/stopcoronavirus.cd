import SpinnerGrowing from './components/SpinnerGrowing';
import Loading from './components/Loading';

const GlobalComponents = {
    install (Vue) {
        Vue.component('SpinnerGrowing',SpinnerGrowing);
        Vue.component('Loading',Loading);
    }
  }
  
  export default GlobalComponents