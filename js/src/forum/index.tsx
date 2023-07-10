import app from "flarum/forum/app";
import { extend } from "flarum/common/extend";
import SignUpModal from "flarum/forum/components/SignUpModal";
import MathCaptcha from "./states/MathCaptcha";

app.initializers.add("nearata-custom-captcha", () => {
  extend(SignUpModal.prototype, "oninit", function () {
    if (
      !app.forum.attribute<boolean>("nearata-custom-captcha.signup_enabled")
    ) {
      return;
    }

    if (
      app.forum.attribute<string>("nearata-custom-captcha.signup_type") ===
      "math"
    ) {
      this.mathCaptcha = new MathCaptcha();
      this.mathCaptcha.load();
    }
  });

  extend(SignUpModal.prototype, "fields", function (items) {
    if (this.mathCaptcha) {
      items.add(
        "nearataCustomCaptcha",
        <div className="Form-group NearataCustomCaptcha">
          <label>
            {app.translator.trans(
              "nearata-custom-captcha.forum.signup.math.input_label"
            )}
          </label>
          <div class="question">{this.mathCaptcha.question()}</div>
          <div>
            <input
              className="FormControl answer"
              name="captcha"
              type="text"
              placeholder={app.translator.trans(
                "nearata-custom-captcha.forum.signup.math.input_placeholder"
              )}
              aria-label={app.translator.trans(
                "nearata-custom-captcha.forum.signup.math.input_aria_label"
              )}
              bidi={this.mathCaptcha.answer}
            />
          </div>
        </div>
      );
    }
  });

  extend(SignUpModal.prototype, "submitData", function (data) {
    if (this.mathCaptcha) {
      data["nearataCustomCaptcha"] = this.mathCaptcha.answer();
    }
  });
});
