function validateForm() {
    var letters = /^[А-Яа-я]+$/;
    var numbers = /^[0-9]+$/;
    var mailf = /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/;
    var x = document.forms["form"]["name"].value;
    var y = document.forms["form"]["email"].value;
    var z = document.forms["form"]["telephone"].value;
    if (x == "" ) {
        alert("Необходимо ввести имя");
        return false;
    }
    else if (!x.match(letters))
        {
            alert("Имя содержит только буквы");
            return false;
        }
    else if (y == "")
    {
        alert("Необходимо ввести электронную почту");
        return false;
    }
    else if (!y.match(mailf))
        {
            alert("Неверный формат электронной почты");
            return false;
        }
    else if (z=="")
        {
            alert("Необходимо ввести номер телефона");
        return false;
        }
    else if (!z.match(numbers))
        {
            alert("Номер телефона содержит только цифры");
            return false;
        }
    else if (z.length!=10)
        {
            alert("Номер телефона содержит 10 цифр");
            return false;
        }
    else if (z[0] != 0)
        {
            alert("Номер телефона начинается с 0");
            return false;
        }
    else {
        return true;
    }
}
