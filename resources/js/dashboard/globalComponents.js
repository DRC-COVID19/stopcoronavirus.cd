import SpinnerGrowing from './components/SpinnerGrowing';
import Loading from './components/Loading';
import LegendPopover from "./components/LegendPopover";
import FullScreen from './components/FullScreen';


const GlobalComponents = {
    install(Vue) {
        Vue.component('SpinnerGrowing', SpinnerGrowing);
        Vue.component('Loading', Loading);
        Vue.component('LegendPopover', LegendPopover);
        Vue.component('FullScreen', FullScreen);
    }
}

export default GlobalComponents
