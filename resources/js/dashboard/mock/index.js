import predictions from './data/predictions';
const fetch = (mockData, time = 0) => {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve({ data: mockData });
    }, time);
  });
};
export default {
  fetchPredictions() {
    return fetch(predictions, 3000);
  },
};
