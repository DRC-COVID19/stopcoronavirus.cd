import SpinnerGrowing from './components/SpinnerGrowing';
import Loading from './components/Loading';
import LegendPopover from "./components/LegendPopover";

const GlobalComponents = {
    install (Vue) {
        Vue.component('SpinnerGrowing',SpinnerGrowing);
        Vue.component('Loading',Loading);
        Vue.component('LegendPopover',LegendPopover);
    }
  }

  export default GlobalComponents
