PSPDFKit.load({
      container: "#pspdfkit",
      document: "/uploads/task_docs/document.pdf" // Add the path to your document here.
})
      .then(function (instance) {
            console.log("PSPDFKit loaded", instance);
      })
      .catch(function (error) {
            console.error(error.message);
      });
