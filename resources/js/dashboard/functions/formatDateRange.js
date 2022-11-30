import { format } from 'date-fns';
export const getFormattedDates = (range) => {
  return {
    start: format(new Date(range.start), 'yyyy-MM-dd'),
    end: format(new Date(range.end), 'yyyy-MM-dd'),
  };
};
