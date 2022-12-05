const FORM_FIELD_TYPE_NUMBER = 2;

export const groupByFormStepField = (formFields) => {
  const formSteps = [];
  formFields.foreach((formField) => {
    const index = formSteps.findIndex(
      (formStep) => formStep.id === formField.form_step_id
    );
    if (index !== -1) {
      formSteps[index].form_fields.push(formField);
    } else {
      formSteps.push({
        ...formField.form_step,
        form_fields: [formField],
      });
    }
  });
  return formSteps;
};

export const groupAggregatedDataByFormStepField = (aggregatedFormFields) => {
  const formSteps = [];
  aggregatedFormFields.forEach((aggregatedFormField) => {
    const index = formSteps.findIndex(
      (formStep) => formStep.id === aggregatedFormField.form_field.form_step_id
    );
    if (index !== -1) {
      formSteps[index].aggregated_form_fields.push(aggregatedFormField);
    } else {
      formSteps.push({
        ...aggregatedFormField.form_field.form_step,
        aggregated_form_fields: [aggregatedFormField],
      });
    }
  });
  return formSteps;
};

export const getAggregatedHospitalsDatas = (hospitalsData) => {
  const completedFormFields = hospitalsData
    .flatMap((hospitalData) => hospitalData.completed_forms)
    .flatMap((completedForm) => completedForm.completed_form_fields)
    .filter(
      (completedFormField) =>
        completedFormField.form_field.form_field_type_id ===
        FORM_FIELD_TYPE_NUMBER
    );

  let completedFormFieldsGroup = [];

  completedFormFields.forEach((completedFormField) => {
    const index = completedFormFieldsGroup.findIndex(
      (completedFormFieldGroup) =>
        completedFormFieldGroup.form_field.id ===
        completedFormField.form_field_id
    );
    if (index !== -1) {
      completedFormFieldsGroup[index].value += completedFormField.value;
      completedFormFieldsGroup[index].count++;
    } else {
      completedFormFieldsGroup.push({
        form_field: completedFormField.form_field,
        aggregated_form_field: {
          id: completedFormField.form_field_id,
          value: completedFormField.value,
          count: 1,
        },
      });
    }
  });
  completedFormFieldsGroup = completedFormFieldsGroup.map(
    (completedFormFieldGroup) => {
      if (!completedFormFieldGroup.form_field.agreggation) {
        completedFormFieldGroup.value /= completedFormFieldGroup.count;
        completedFormFieldGroup.value =
          completedFormFieldGroup.value.toFixed(2);
      }
      return completedFormFieldGroup;
    }
  );

  return completedFormFieldsGroup;
};
