export const onlyLetters = () => {
  let regex = new RegExp("^[a-zA-Z ]+$");
  $(".letters").bind("keypress", function (event) {
    let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });
};

export const onlyNumbers = () =>{
    let regex = new RegExp("^[0-9]+$");
    $(".numbers").bind("keypress", function () {
        let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
};

export const numberDecimal = () =>{
    let regex = new RegExp("^[0-9,.]+$");
    $(".decimals").bind("keypress", function () {
        let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
};




