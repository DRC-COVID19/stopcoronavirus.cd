import { extend } from "vee-validate";

extend("min", {
  validate(value, args) {
    return value.length >= args.length;
  },
  params: ["length"],
  message:
    "The {_field_} field must have at least {min} characters and {max} characters at most",
});
