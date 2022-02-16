export default {
    state: {
        activeMenu: null
    },
    mutations: {
        setActiveMenu(state, payload) {
            state.activeMenu = payload;
        }
    }
}
