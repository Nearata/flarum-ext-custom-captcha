import Stream from "flarum/common/utils/Stream";
import app from "flarum/forum/app";

export default class MathCaptcha {
  question: Stream<string>;
  answer: Stream<string>;

  constructor() {
    this.question = Stream("");
    this.answer = Stream("");
  }

  async load() {
    await app
      .request({
        url: `${app.forum.attribute(
          "apiUrl"
        )}/nearata/customCaptcha/generate/math`,
      })
      .then((r: any) => {
        this.question(r.question);
      })
      .catch(() => {})
      .finally(() => {});
  }
}
