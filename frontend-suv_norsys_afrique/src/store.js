import Vue from "vue";
export const store = Vue.observable({
  dates: '',
});
export const mutations = {
    setDates(dates) {
      store.dates = dates;
    },
    padTo2Digits(num) {
      return num.toString().padStart(2, '0');
    },
    formatDate(date) {
      return [
        date.getFullYear(),
        this.padTo2Digits(date.getMonth() + 1),
        this.padTo2Digits(date.getDate()),
      ].join('-');
    },
};