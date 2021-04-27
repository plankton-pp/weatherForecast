<!DOCTYPE html>
<html>
<head>
    <title>Weather Forecast</title>
    <meta charset="UTF-8">
    <link rel="icon" href="imgs/icon.svg">
    <!--===================================================== CSS  ===============================================================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--========================================================================================================================================-->
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <!--========================================================================================================================================-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    <!--========================================================================================================================================-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" crossorigin="anonymous">
    <!--========================================================================================================================================-->

    <!--===================================================Java Script=========================================================================-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!--========================================================================================================================================-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!--========================================================================================================================================-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!--========================================================================================================================================-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
    <!--========================================================================================================================================-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <!--========================================================================================================================================-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!--========================================================================================================================================-->
    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
    <!--========================================================================================================================================-->
    <link rel="stylesheet" href="weather.css">
</head>

<body>
    <ul>
      <li><h1 style="margin-left: 20%;color:white;">Weather Forcast</h1></li>
    </ul>

    <table width="1000" align="center">
        <br />
        <br />
        <tr>
            <td>

                    <select class="form-control" id="selectRegion" style="font-size: 24px">
                        <option value="null">เลือกภูมิภาค</option>
                        <option value="C">ภาคกลาง</option>
                        <option value="N">ภาคเหนือ</option>
                        <option value="NE">ภาคตะวันออกเฉียงเหนือ</option>
                        <option value="E">ภาคตะวันออก</option>
                        <option value="S">ภาคใต้</option>
                        <option value="W">ภาคตะวันตก</option>
                    </select>
            </td>
            <td >
                &nbsp;
                <button type="button" class="btn btn-primary" id="btnGetData" style="width: 40%;font-size: 24px;">GO !</button>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <div id="showData" align="center"></div>
    </table>
    <div id="modal"></div>
</body>
 <script>
    //global var
        var dateTime_global=[];
        var addr_name =[];
        var modalContent = [];
        var loading = "<br /><br /><br /><br /><br /><br /><br /><br />"+
                                    "<div class=\"text-center\" style=\"align:center\">"+
                                      "<div class=\"spinner-border\" role=\"status\">"+
                                        "<span class=\"sr-only\">Loading...</span>"+
                                      "</div>"+
                                    "</div>";
        $("#btnGetData").click(function () {

            var region = $("#selectRegion").val();
            if(region == "null") {
                alert("โปรดเลือกภูมิภาค");
            } else {
                $('#showData').html(loading);
                $daily_url = "https://data.tmd.go.th/nwpapi/v1/forecast/location/daily/region?region="+region+"&fields=tc_max,tc_min,cond";
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": $daily_url,
                    "method": "GET",
                    "headers": {
                        "accept": "application/json",
                        "authorization": " Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVkMTk0M2ZjODA3ODM4MDZiM2JhMzg0ODhlOGNkMTY4ZjYzMTBiN2Y2YzFkNDI5MWQ2ZmFhNTcwNDUwYTNiYTA0NzZiMGU2ODkyN2JlYWI4In0.eyJhdWQiOiIyIiwianRpIjoiNWQxOTQzZmM4MDc4MzgwNmIzYmEzODQ4OGU4Y2QxNjhmNjMxMGI3ZjZjMWQ0MjkxZDZmYWE1NzA0NTBhM2JhMDQ3NmIwZTY4OTI3YmVhYjgiLCJpYXQiOjE2MTkxNzAyOTAsIm5iZiI6MTYxOTE3MDI5MCwiZXhwIjoxNjUwNzA2MjkwLCJzdWIiOiIxNDEyIiwic2NvcGVzIjpbXX0.wSMbnRXc8baTLOuXw1bb15aF5wW00wxdUpmPQKIxPXu91TBmLsEN8C0EDm9Q6XJ_lNLwfKhIwGU887OLVKmfn4eHNV-bPnH1StAnK33B_50mhJEltR3xbXRY28GtWXbqPV59jvFQVsloe2Z5mS4U1GoxP3jyKKFDXPNHkmYsHKd3pmoTNswV39Ken2LvRGBWRsKJwwe0AtfPFuRVctWsHCraPFAcux7e8IAQD9v5U0iBBFDCtZfCA0QtmL_ttI4xrhQagRIptzMurxoXAI3wBAVSldh7Vfsoa-8V_id1BWCJ0TYHGZjmiHnLP_RjXUnl-mvn6uxXOPuL96ndH8RQbpaKHw2Lr50eHsEuCPY0yYbnUCVEhtrw0Coav14Sfj7XIl429E-FLcgSiOoM_uh6-h2LDbvLSOeNmGDmHrLp_Mt_TsZvZ56zHQPrvqqDyXAlqGqPY3uiJctO1s7vwM9zF5XIHRCEJ-HTSDI0dkjfGXxdeKMmLZKrAIkZ4t_VBldrFWAaf4W6KgGL08Wt_yAxrWcmh7JzO4WZ34AVuttMds9zEyAJPQgee8Qs_1UUla7JceV-HQl_nZ7GfG3PprBDkHxbl_rh8lN8CHcsSCKLoVF-yElCjIDEmgZiJwir50wtviVPvofue8xlJQRJrkRoIW8tyaBy5nCMST5Fcjs4GK8",
                    }
                }


                $.ajax(settings).done(function (response) {
                    var str = [];
                    var weather = "null";
                    var icon = "null";
                    var data = "";
                    var dateTime = response.WeatherForecasts[0].forecasts[0].time;
                    var dateTimeArray = dateTime.split("T");
                    var datePack = dateTimeArray[0];
                    var time = dateTimeArray[1];

                    dateTime_global[0] = datePack;
                    dateTime_global[1] = time;
                    var dateArray = datePack.split("-");
                    var date = dateArray[2];
                    var month = dateArray[1];
                    var year = dateArray[0];
                    var tempData="";
                    var monthNameTH="";
                    var yearTH = parseInt(year)+543;

                    switch(month){
                        case "01":monthNameTH="มกราคม";break;
                        case "02":monthNameTH="กุมภาพันธ์";break;
                        case "03":monthNameTH="มีนาคม";break;
                        case "04":monthNameTH="เมษายน";break;
                        case "05":monthNameTH="พฤษภาคม";break;
                        case "06":monthNameTH="มิถุนายน";break;
                        case "07":monthNameTH="กรกฎาคม";break;
                        case "08":monthNameTH="สิงหาคม";break;
                        case "09":monthNameTH="กันยายน";break;
                        case "10":monthNameTH="ตุลาคม";break;
                        case "11":monthNameTH="พฤศจิกายน";break;
                        case "12":monthNameTH="ธันวาคม";break;
                        default:break;

                    }
                    str.push("<h3><b><br />ภาพรวมสภาพอากาศในแต่ละจังหวัด<br /><br />ประจำวันที่ : "+date+" "+monthNameTH+" "+yearTH+"</b></h3><br>==================================================<br><br>")
                    for(var i=0 ; i< response.WeatherForecasts.length ; i++) {
                        switch(response.WeatherForecasts[i].forecasts[0].data.cond){
                            case 1:weather = "ท้องฟ้าแจ่มใส";icon = "windy.png";break;
                            case 2:weather = "มีเมฆบางส่วน";icon = "cloudy.png";break;
                            case 3:weather = "เมฆเป็นส่วนมาก";icon = "clouds.png";break;
                            case 4:weather = "มีเมฆมาก";icon = "clouds.png";break;
                            case 5:weather = "ฝนตกเล็กน้อย";icon = "drop.png";break;
                            case 6:weather = "ฝนปานกลาง";icon = "rain.png";break;
                            case 7:weather = "ฝนตกหนัก";icon = "rainy.png";break;
                            case 8:weather = "ฝนฟ้าคะนอง";icon = "storm.png";break;
                            case 9:weather = "อากาศหนาวจัด";icon = "snow.png";break;
                            case 10:weather = "อากาศหนาว";icon = "snowflake.png";break;
                            case 11:weather = "อากาศเย็น";icon = "temperature.png";break;
                            case 12:weather = "อากาศร้อนจัด";icon = "sun.png";break;
                            default:break;
                        }
                        var color = "";
                        switch(i%5){
                            case 0:color="#F8B195";break;
                            case 1:color="#F67280";break;
                            case 2:color="#C06C84";break;
                            case 3:color="#6C5B7B";break;
                            case 4:color="#355C7D";break;
                            default:break;
                        }
                        if(i%5==0){
                            data += "<tr>";
                        }
                        var province = response.WeatherForecasts[i].location.province;
                        var temperature_max = response.WeatherForecasts[i].forecasts[0].data.tc_max;
                        var temperature_min = response.WeatherForecasts[i].forecasts[0].data.tc_min;
                            data +="<td><div class=\"card\" id=\""+province+"\" onclick=\"callModal(this.id)\">"+         
                                        "<div class=\"imgcard\"><img src=\"imgs/"+icon+"\" style=\"width: 60%;\"></div><br />"+
                                        "<div class=\"container\">"+
                                        "<div class=\"subcontainer\" style=\"background-color: "+color+";\"><br />"+
                                            "<h5><b>" + province + "</b></h5>" +
                                            "<h6>อุณหภูมิ: </h6><span><b>"+temperature_max+" °C/</b>"+temperature_min+" °C</span><br />"+
                                            "สภาพอากาศ : " + weather+ "<br><br>"+
                                        "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</td>";
                        if(i%5==4){
                            data += "</tr>";
                        }
                    }
                    if(data!=tempData){
                        str.push(data);
                        $("#showData").html(str);
                        tempData = data;
                    }
                });
            }
        });
    function callModal(id){
        if (typeof(Storage) !== "undefined") {
          // Store
          window.sessionStorage.setItem("id", id);
        }
        Modal(id);
    }
    function Modal(id){
        let tmp = window.sessionStorage.getItem("id");  
        getModalContent(id,0);
        var modalTag ="<!-- Modal -->"+
                        "<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">"+
                          "<div class=\"modal-dialog modal-lg\" role=\"document\">"+
                            "<div class=\"modal-content\">"+
                              "<div class=\"modal-header\">"+
                                "<h5 class=\"modal-title\" id=\"exampleModalLabel\">"+id+"</h5>"+
                                "<div onclick=\"closeModal()\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">"+
                                  "<span aria-hidden=\"true\">&times;</span>"+
                                "</button></div>"+
                              "</div>"+
                              "<div class=\"modal-body\">"+
                              "<div style=\"margin-left:2%\">"+
                              "<button class=\"btn btn-secondary\" onclick=\"getModalContent(0,0);\"> ปัจจุบัน </button>&nbsp;&nbsp;"+
                              "<button class=\"btn btn-secondary\" onclick=\"getModalContent(0,1);\"> 1 ชม.ที่แล้ว </button>&nbsp;&nbsp;"+
                              "<button class=\"btn btn-secondary\" onclick=\"getModalContent(0,5);\"> 5 ชม.ที่แล้ว </button>&nbsp;&nbsp;"+
                              "<button class=\"btn btn-secondary\" onclick=\"getModalContent(0,9);\"> 10 ชม.ที่แล้ว </button>&nbsp;&nbsp;"+
                              "</div>"+
                                "<div id=\"modalContent\">"+
                                    "<br />"+
                                        "<div class=\"text-center\" style=\"align:center\">"+
                                          "<div class=\"spinner-border\" role=\"status\">"+
                                            "<span class=\"sr-only\">Loading...</span>"+
                                          "</div>"+
                                        "</div>"+
                                    "</div>"+
                                  "</div><br />"+
                              "<div class=\"modal-footer\">"+
                                "<div id=\"closeModal\" onclick=\"closeModal()\"><button class=\"btn btn-secondary\"> Close </button></div>"+
                              "</div>"+
                            "</div>"+
                          "</div>"+
                        "</div>";
        $("#modal").html(modalTag);
        $("#exampleModal").modal('show');
    }

    function closeModal(){
        $("#exampleModal").modal('hide');   
    }
    function getModalContent(province,backward_time){
        modalContent = [];
        addr_name = [];
        if(province==0){
            province = String(window.sessionStorage.getItem("id"));
        }
        alert("check: "+province);
        var current = new Date();
        var date = current.getDate();
        var hour = "";
        var time = "";
        var place_url = "";
        //retrieving backward data
        if(backward_time!=0){
            //set screen to loading
            $('#modalContent').html(loading);
            let diff = current.getHours()-backward_time;
            if(diff<0){
                //change date, time
                date-=1;
                hrs = 24+diff;
                if(hrs<10){
                    hour ="0"+hrs;
                }else{
                    hour = hrs;
                }
            }else{
                //change only time
                hour = diff;
            }
            time = hour + ":00" + ":00";
            place_url = "https://data.tmd.go.th/nwpapi/v1/forecast/area/place?domain=2&province="+province+"&fields=tc,rh,cond&starttime=2021-04-"+date+"T"+time;
        }else{

            if(current.getHours()<10){
                hour ="0"+current.getHours();
            }else{
                hour = current.getHours();
            }
            time = hour + ":00" + ":00";
            place_url = "https://data.tmd.go.th/nwpapi/v1/forecast/area/place?domain=2&province="+province+"&fields=tc,rh,cond&starttime=2021-04-"+date+"T"+time;
        }
        var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": place_url,
                    "method": "GET",
                    "headers": {
                        "accept": "application/json",
                        "authorization": " Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVkMTk0M2ZjODA3ODM4MDZiM2JhMzg0ODhlOGNkMTY4ZjYzMTBiN2Y2YzFkNDI5MWQ2ZmFhNTcwNDUwYTNiYTA0NzZiMGU2ODkyN2JlYWI4In0.eyJhdWQiOiIyIiwianRpIjoiNWQxOTQzZmM4MDc4MzgwNmIzYmEzODQ4OGU4Y2QxNjhmNjMxMGI3ZjZjMWQ0MjkxZDZmYWE1NzA0NTBhM2JhMDQ3NmIwZTY4OTI3YmVhYjgiLCJpYXQiOjE2MTkxNzAyOTAsIm5iZiI6MTYxOTE3MDI5MCwiZXhwIjoxNjUwNzA2MjkwLCJzdWIiOiIxNDEyIiwic2NvcGVzIjpbXX0.wSMbnRXc8baTLOuXw1bb15aF5wW00wxdUpmPQKIxPXu91TBmLsEN8C0EDm9Q6XJ_lNLwfKhIwGU887OLVKmfn4eHNV-bPnH1StAnK33B_50mhJEltR3xbXRY28GtWXbqPV59jvFQVsloe2Z5mS4U1GoxP3jyKKFDXPNHkmYsHKd3pmoTNswV39Ken2LvRGBWRsKJwwe0AtfPFuRVctWsHCraPFAcux7e8IAQD9v5U0iBBFDCtZfCA0QtmL_ttI4xrhQagRIptzMurxoXAI3wBAVSldh7Vfsoa-8V_id1BWCJ0TYHGZjmiHnLP_RjXUnl-mvn6uxXOPuL96ndH8RQbpaKHw2Lr50eHsEuCPY0yYbnUCVEhtrw0Coav14Sfj7XIl429E-FLcgSiOoM_uh6-h2LDbvLSOeNmGDmHrLp_Mt_TsZvZ56zHQPrvqqDyXAlqGqPY3uiJctO1s7vwM9zF5XIHRCEJ-HTSDI0dkjfGXxdeKMmLZKrAIkZ4t_VBldrFWAaf4W6KgGL08Wt_yAxrWcmh7JzO4WZ34AVuttMds9zEyAJPQgee8Qs_1UUla7JceV-HQl_nZ7GfG3PprBDkHxbl_rh8lN8CHcsSCKLoVF-yElCjIDEmgZiJwir50wtviVPvofue8xlJQRJrkRoIW8tyaBy5nCMST5Fcjs4GK8",
                    }
                }

        var lat,lon,tc,rh,cond,place;
        $.ajax(settings).done(function(response){
            //set array empty
            addr_name=[];
            var str="";
            var weather="";
            var icon="";
            var iconPack=[];
            //loop for get tmd information by area
            for(var i=0 ; i< response.WeatherForecasts.length ; i++){
                lat = response.WeatherForecasts[i].location.lat;
                lon = response.WeatherForecasts[i].location.lon;
                tc = response.WeatherForecasts[i].forecasts[0].data.tc;
                rh = response.WeatherForecasts[i].forecasts[0].data.rh;
                cond = response.WeatherForecasts[i].forecasts[0].data.cond;

                switch(cond){
                            case 1:weather = "ท้องฟ้าแจ่มใส";icon = "windy.png";break;
                            case 2:weather = "มีเมฆบางส่วน";icon = "cloudy.png";break;
                            case 3:weather = "เมฆเป็นส่วนมาก";icon = "clouds.png";break;
                            case 4:weather = "มีเมฆมาก";icon = "clouds.png";break;
                            case 5:weather = "ฝนตกเล็กน้อย";icon = "drop.png";break;
                            case 6:weather = "ฝนปานกลาง";icon = "rain.png";break;
                            case 7:weather = "ฝนตกหนัก";icon = "rainy.png";break;
                            case 8:weather = "ฝนฟ้าคะนอง";icon = "storm.png";break;
                            case 9:weather = "อากาศหนาวจัด";icon = "snow.png";break;
                            case 10:weather = "อากาศหนาว";icon = "snowflake.png";break;
                            case 11:weather = "อากาศเย็น";icon = "temperature.png";break;
                            case 12:weather = "อากาศร้อนจัด";icon = "sun.png";break;
                            default:break;
                        }

                str = "พิกัด: "+lat+", "+lon;
                str+= "<br />อุณหภูมิ: "+tc+" °C";
                str+= "<br />ความชื้น: "+rh+"%";
                str+= "<br />สภาพอากาศ: "+weather;
                iconPack.push(icon);

                //execute function to set global array variable
                getLocName(lat,lon,str,iconPack);
            }
        });
    }
    function getLocName(lat,lon,str,icon){
        var apiKEY = "AIzaSyB_EQsZVoBQ5LVPRtRzhTG0YphEZjvdV7M"
        var mapAPI = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lon+"&key="+apiKEY;
        var mapPackage = {
                    "url":mapAPI
                }

        $.ajax(mapPackage).done(function (loc){
            let size = loc.results.length;
            let last = size-1;
            let address;
            try{
                address = loc.results[last].plus_code.compound_code;
            }catch(err){
                console.log("_error on line 300: try to search for loc_name");
                address = "null";
            }
            if(address!="null"){
                address = address.substr(7,address.length);
            }
            addr_name.push(address);
            console.log(addr_name);
            setModalContent(str,addr_name,icon);
        });
    }
    function setModalContent(content,location,icon){
        modalContent.push(content);
        var htmlString =""; 
        for(i=0;i<modalContent.length;i++){
            if(location[i]!="null"){
                htmlString+="<tr><td align=\"center\"><div><img src=\"imgs/"+icon[i]+"\" style=\"width: 30%;\"></div></td>"
                htmlString+="<td>";
                htmlString += "<h5>"+location[i]+"</h5>"+modalContent[i]+"<br /><br /><hr>";
                htmlString+="</td></tr>";
            }
        }
        //set content to modal when the data retrieved
        $('#modalContent').html("<table>"+htmlString)+"</table>";
    }
    </script>