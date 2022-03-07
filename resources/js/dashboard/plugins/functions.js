export const createSituationsReduce = (array = []) => {
  const formIds = []
  if (array.length > 0) {
    array
      ?.slice()
      .sort(
        (prevFormItem, nextFormItem) =>
          prevFormItem.form_step_id - nextFormItem.form_step_id
      )
      .forEach(item => {
        if (formIds.every(form => form.form_step_id !== item.form_step_id)) {
          formIds.push({
            form_step_id: item.form_step_id,
            form_step_title:
              item.form_step_id === null ? 'Aucune etape' : item.form_step_title
          })
        }
      })
    const formStepsList = formIds.map(form => {
      const formStep = {
        form_step_id: form.form_step_id,
        form_step_title: form.form_step_title
      }
      formStep.form_field_values = array.filter(
        arr => arr.form_step_id == formStep.form_step_id
      )
      return formStep
    })
    return formStepsList
  }
  return []
}

export const renderDiffDate = (moment, date) => {
  const dateFormat = moment(date)
  const curDate = moment(new Date())

  return curDate.diff(dateFormat, 'days')
}
