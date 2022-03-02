export const groupByFormStepField = (formFields) => {
  const formSteps = []
  formFields.foreach(formField => {
    const index = formSteps.findIndex(formStep => formStep.id === formField.form_step_id)
    if (index !== -1) {
      formSteps[index].form_fields.push(formField)
    } else {
      formSteps.push({
        ...formField.form_step,
        form_fields: [formField]
      })
    }
  })
  return formSteps
}

export const groupAggregatedDataByFormStepField = (aggregatedFormFields) => {
  const formSteps = []
  aggregatedFormFields.forEach(aggregatedFormField => {
    const index = formSteps.findIndex(formStep => formStep.id === aggregatedFormField.form_field.form_step_id)
    if (index !== -1) {
      formSteps[index].aggregated_form_fields.push(aggregatedFormField)
    } else {
      formSteps.push({
        ...aggregatedFormField.form_field.form_step,
        aggregated_form_fields: [aggregatedFormField]
      })
    }
  })
  return formSteps
}
