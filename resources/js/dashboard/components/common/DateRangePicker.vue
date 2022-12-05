<template>
  <v-date-picker
    v-model="dateRange"
    opens="center"
    :max-date="new Date()"
    class="d-flex style-picker"
    :mode="mode"
    :is-range="isRanged"
    show-weeknumbers
    :is-expanded="true"
    :attributes="attributes"
    popover.keepVisibleOnInput
  >
    <template v-slot="{ inputEvents }">
      <div
        class="w-100 d-flex flex-col sm:flex-row justify-content-center text-center item-center btn-container-calendar overflow-hidden"
      >
        <input
          id="range"
          class="p-1 pl-2 w-full"
          :value="
            isRanged
              ? `${moment(dateRange.start).format('YYYY/MM/DD')}- ${moment(
                  dateRange.end
                ).format('YYYY/MM/DD')}`
              : moment(dateRange).format('YYYY/MM/DD')
          "
          v-on="isRanged ? inputEvents.end : inputEvents"
          readonly
        />
        <i for="range" class="fas fa-light fa-calendar p-2"></i>
      </div>
    </template>
    <div
      slot="footer"
      slot-scope=""
      class="d-flex justify-content-between ml-2 mr-2 mb-2 mt-n2"
      style="width: 330px"
    >
      <span
        class="btn-range-date"
        @click="activeStartDate"
        style="cursor: pointer"
        >{{
          isRanged
            ? moment(dateRange.start).format('YYYY/MM/DD')
            : 'Date début'
        }}<i :class="iconStateDatePicker" class="ml-1"></i>
      </span>
      <span class="btn-range-date">{{
        isRanged
          ? moment(dateRange.end).format('YYYY/MM/DD')
          : moment(dateRange).format('YYYY/MM/DD')
      }}</span>
    </div>
  </v-date-picker>
</template>

<script>
import DateRangePicker from 'vue2-daterange-picker';

export default {
  components: { DateRangePicker },
  data() {
    return {
      mode: 'date',
      isRanged: false,
      dateRange: this.isRanged
        ? {
            start: new Date(),
            end: new Date(),
          }
        : new Date(),
      attributes: [],
      iconStateDatePicker: 'fas fa-thin fa-plus',
      isUpdate: false,
    };
  },
  methods: {
    activeStartDate() {
      this.isRanged = !this.isRanged;
      this.mode = this.mode === 'date' ? 'range' : 'date';
      this.iconStateDatePicker =
        this.iconStateDatePicker == 'fas fa-thin fa-plus'
          ? 'fa fa-times'
          : 'fas fa-thin fa-plus';

      this.attributes[0] = {
        key: 'today',
        dates: this.isRanged
          ? { start: this.dateRange.start, end: this.dateRange.end }
          : this.dateRange,
        highlight: true,
      };
    },
  },
};
</script>

<style lang="scss" scoped>
.btn-submit {
  font-size: 14px;
}
.btn-clear-observation {
  height: 32px;
  margin-left: 5px;
  display: flex;
  align-items: center;
}

.btn-range-date {
  font-size: 16px;
  padding: 5px;
  text-align: center;
  width: 45%;
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
}
.btn-calendar {
  font-size: 16px;
  padding-right: 10px;
}
.btn-container-calendar {
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
  width: 100%;
  align-items: center;
  background-color: #f4f5fc;

  input {
    border: none !important;
    width: 100%;
    height: 100%;
    font-size: 13px;
    color: #333 !important;
    &:focus {
      border: none !important;
      outline: none !important;
    }
  }
  label {
    width: 15%;
    align-self: center;
    align-items: center;
    text-align: center;
  }
  i {
    background-color: #ffffff;
    color: #c3c8ce;
  }
  &:hover {
    cursor: pointer;
  }
}
</style>
