
const data = {
  data: [
    {
      from: new Date(2018, 7),
      title: "Name",
      description:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius earum architecto dolor, vitae magnam voluptate accusantium assumenda numquam error mollitia, officia facere consequuntur reprehenderit cum voluptates, ea tempore beatae unde.",
      showDayAndMonth: true,
      notRead: true
    },

    {
      from: new Date(2016, 1),
      title: "Name",
      description:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius earum architecto dolor, vitae magnam voluptate accusantium assumenda numquam error mollitia, officia facere consequuntur reprehenderit cum voluptates, ea tempore beatae unde.",
      showDayAndMonth: true,
    },
    {
      from: new Date(2016, 6),
      title: "Name",
      description:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius earum architecto dolor, vitae magnam voluptate accusantium assumenda numquam error mollitia, officia facere consequuntur reprehenderit cum voluptates, ea tempore beatae unde.",
      showDayAndMonth: true,
    },
    {
      from: new Date(2012, 1),
      title: "Name",
      description:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius earum architecto dolor, vitae magnam voluptate accusantium assumenda numquam error mollitia, officia facere consequuntur reprehenderit cum voluptates, ea tempore beatae unde.",
      showDayAndMonth: true,
    },
  ],
  meta: {
    current_page: 1,
    from: 1,
    last_page: 19,
    path: "http:\/\/localhost:8000\/api\/pandemic-stats",
    per_page: 15,
    to: 15,
    total: 281
  }
};

export default {
  state: {
    listChangeLogs: {},
    currentPage: 1,
    isLoading: false
  },
  mutations: {
    setListChangeLogs(state, payload) {
      state.listChangeLogs = payload;
    },
    setIsLoading(state, payload) {
      state.isLoading = payload;
    },
  },
  actions: {
    getListChangedLogs({ state, commit }, payload) {
      commit("setIsLoading", true);
      return new Promise((resolve, reject) => {
        commit('setListChangeLogs', data);
        resolve(true)
        commit("setIsLoading", false);
      })
    },
    setChangeLogsRead({ state }) {
      state.listChangeLogs.data.map(item => {
        item.notRead = false;
      });
    }
  },
  getters: {
    getChangeLogNotRead(state) {
      if (!state.listChangeLogs.data) {
        return []
      }
      return state.listChangeLogs.data.filter((x) => x.notRead);
    }
  }
}
