import { format } from 'date-fns';
export const getFormattedDate = (date) => format(new Date(date), 'yyyy-MM-dd');

export const getFormattedDates = (range) => {
  return {
    start: format(new Date(range.start), 'yyyy-MM-dd'),
    end: format(new Date(range.end), 'yyyy-MM-dd'),
  };
};
