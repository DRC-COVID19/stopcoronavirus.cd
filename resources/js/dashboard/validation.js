import { extend } from 'vee-validate'
import { required, email, confirmed, regex, numeric } from 'vee-validate/dist/rules'

extend('email', { ...email, message: 'Adresse mail incorrecte' })
extend('required', {
  ...required,
  message: 'Le champ "{_field_}" est requis'
})
extend('confirmed', {
  ...confirmed,
  message: 'Le mot de passes ne correspond pas'
})

extend('numeric', {
  ...numeric,
  message: 'Le Champ "{_field_}" doit être un nombre'
})
extend('regex', {
  ...regex,
  message: '{_field_} est incorrect',
  validate: (value) => /^0[8-9][0-9]{8}$/.test(value)
})

// validate(password, "required|confirmed:@confirmation", {
//   name: "Password",
//   values: {
//     confirmation,
//   },
// }).then((result) => {
//   if (result.valid) {
//     // Do something!
//   }
// });
