module.exports = {
  publicPath:
    process.env.NODE_ENV === "production" ? "/app/whistleblower" : "/",
  indexPath: "index.php",

  transpileDependencies: ["vuetify"],
};
