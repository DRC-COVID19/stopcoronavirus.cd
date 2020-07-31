export default {
    state: {
        activeMenu: 1
    },
    mutations: {
        setActiveMenu(state, payload) {
            state.activeMenu = payload;
        }
    }
}