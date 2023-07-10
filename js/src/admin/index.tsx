import app from "flarum/admin/app";

app.initializers.add("nearata-custom-captcha", () => {
  app.extensionData
    .for("nearata-custom-captcha")
    .registerSetting(function () {
      return (
        <h2>
          {app.translator.trans(
            "nearata-custom-captcha.admin.settings.signup.section_label"
          )}
        </h2>
      );
    })
    .registerSetting({
      setting: "nearata-custom-captcha.signup_enabled",
      type: "boolean",
      label: app.translator.trans(
        "nearata-custom-captcha.admin.settings.signup.enabled"
      ),
    })
    .registerSetting({
      setting: "nearata-custom-captcha.signup_type",
      type: "select",
      label: app.translator.trans(
        "nearata-custom-captcha.admin.settings.signup.captcha_types.label"
      ),
      options: {
        math: app.translator.trans(
          "nearata-custom-captcha.admin.settings.signup.captcha_types.math"
        ),
      },
    });
});
