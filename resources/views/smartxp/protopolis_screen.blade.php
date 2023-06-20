<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon2.png') }}"/>

    <title>Protopolis Screen v12</title>

    @include('website.assets.stylesheets')

    <style>
        .protubecard{
            background-color: rgb(255 255 255);
            opacity: 0.8;
            width:100%;
            border-radius: 8px;
            overflow: hidden;
            padding:0;
            border: 0px solid #00AAC0;
            border-left-width: 4px;
        }

        .font-size-lg {
            font-size: 1.5rem;
        }

        .scroll-title {
            animation: slide-left 15s linear infinite;
        }

        @keyframes slide-left {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
            100% {
                -webkit-transform: translateX(-50%);
                transform: translateX(-50%);
            }
        }
    </style>

    </style>

</head>

<body class="h-100 w-100" style=" overflow:hidden; padding:30px; background-color:#f1f1f1;">
  <div class="row text-black">

    {{-- narrowcasting--}}
    <div class="col-9" style="border-radius: 8px; padding:0; overflow:hidden;  border: 0px solid #00AAC0;
            border-left-width: 4px;">
        <div >
            @include('narrowcasting.display')
        </div>
    </div>


    <div class="ms-2 col h-auto d-flex flex-column">

        {{-- On screen clock --}}
        <div class="row mb-3">
            <div class="protubecard p-3 text-center font-weight-bold display-3">

                <div id="clock" class="notice">Loading</div>

            </div>
        </div>

        <div class="row flex-grow-1">
            <div id="timetable" class="protubecard p-3">

                <div class="notice">Loading timetable...</div>

            </div>
        </div>


    </div>
  </div>
<div class="row text-black d-flex h-100">
    <div class="col-9 mt-3 h-100" style="padding:0">

        <div id="activities" class="d-flex flex-row mb-3 gap-2" style="height:20%" >

                <div class="notice protubecard flex-grow-1 p-2">
                        <div class="font-weight-bold font-size-lg">Loading events</div>
                </div>
        </div>
    </div>
    <div class="col-3 mt-3 h-100 " style="padding:0 0 0 8px ">
        <div id="protopeners" class="box protubecard p-3" style="height:20%">

            <div class="box-header font-size-lg text-center">
                <i class="fas fa-door-closed fa-fw me-2" id="protopolis-fa"></i>
                Protopolis
            </div>

            <div id="protopeners-timetable" class="h-100"></div>

        </div>
    </div>
</div>

  <script type="text/javascript" nonce="{{ csp_nonce() }}">
      function updateTimetable() {
          const timetable = document.getElementById("timetable")

          get('{{ route('api::screen::timetable') }}')
              .then(data => {
                  if (data.length > 0) {
                      timetable.innerHTML = ''
                      let count = 0
                      data.forEach(timetableItem => {
                          if (count >= 4) return
                          if (!timetableItem.over) {
                              let start = moment.unix(timetableItem.start)
                              let end = moment.unix(timetableItem.end)
                              let time = start.format("HH:mm") + ' - ' + end.format("HH:mm")
                              let title = timetableItem.title
                              let displayTime = '<i class="fas fa-clock fa-fw me-1"></i>' + time + ' <span class="float-end"><i class="fas fa-map-marker-alt fa-fw me-1"></i>' + timetableItem.place + '</span>'
                              timetable.innerHTML +=
                                  '<div class="activity">' +
                                  (timetableItem.studyShort ? '<span class="float-end ms-2">' + '<i class="fas fa-graduation-cap fa-fw me-2"></i>' + timetableItem.studyShort + ' ' + (timetableItem.year ? 'Year ' + timetableItem.year : '') + '</span> ' : null) +
                                  '<strong>' + timetableItem.type + '</strong><br>' +
                                  '<span class="' + (timetableItem.current ? "current" : "") + '">' + title + '</span><br>' +
                                  displayTime +
                                  '</div>'+'<br><hr>'
                              count++
                          }
                      })
                      if (count === 0) {
                          timetable.innerHTML = '<div class="notice">No more lectures today!</div>'
                      }
                  } else {
                      timetable.innerHTML = '<div class="notice">No lectures today!</div>'
                  }
                  setTimeout(updateTimetable, 60000);
              })
              .catch(err => {
                  console.error(err)
                  timetable.innerHTML = '<div class="notice">Lectures could not be found...</div>'
                  setTimeout(updateTimetable, 5000);
              })
      }

      updateTimetable();

      function updateActivities() {
          get('{{ route('api::events::upcoming', ['limit' => 5]) }}')
              .then(data => {

                  if (data.length > 0) {
                      document.getElementById("activities").innerHTML = '';
                      data.forEach((activity) => {
                          let start = moment.unix(activity.start)
                          let end = moment.unix(activity.end)
                          let time
                          if (start.format('DD-MM') === end.format('DD-MM')) {
                              time = start.format("DD-MM, HH:mm") + ' - ' + end.format("HH:mm")
                          } else {
                              time = start.format("DD-MM, HH:mm") + ' - ' + end.format("DD-MM, HH:mm")
                          }
                          let newDiv=document.createElement("div")
                          newDiv.className="activity bg-img protubecard flex-grow-1"+ (activity.current ? "current" : (activity.over ? "past" : ""))
                          newDiv.style.padding='15px'
                          if(activity.image) {
                              newDiv.style.background = 'linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)), url('+activity.image+')'
                              newDiv.style.backgroundSize = 'cover'
                              newDiv.style.backgroundPosition = 'center center'
                              newDiv.style.backgroundRepeat = 'no-repeat'
                          }

                          let titleDiv=document.createElement("div")
                          let titleSpan=document.createElement("span")
                          titleSpan.innerHTML=activity.title
                          titleSpan.className="font-weight-bold font-size-lg text-nowrap"
                          titleDiv.appendChild(titleSpan)
                          let timeDiv=document.createElement("div")
                          timeDiv.innerHTML='<i class="fas fa-clock fa-fw me-1"></i>'+time

                          let locationSpan=document.createElement("div")
                          locationSpan.innerHTML='<i class="fas fa-map-marker-alt fa-fw me-1"></i>' + activity.location + '</span>'

                          newDiv.appendChild(titleDiv)
                          newDiv.appendChild(timeDiv)
                          newDiv.appendChild(locationSpan)

                          document.getElementById("activities").appendChild(newDiv)
                          const textWidth = titleSpan.clientWidth;
                          const parentWidth = newDiv.clientWidth;
                          console.log(textWidth, parentWidth)
                          console.log(titleSpan)
                          if(textWidth > parentWidth) {
                              timeDiv.classList.add('scroll-title')
                          }
                      });
                  } else {
                      document.getElementById("activities").innerHTML = '<div class="notice">No upcoming activities!</div>'
                  }
                  setTimeout(updateActivities, 60000)
              })
              .catch(err => {
                  console.error(err)
                  document.getElementById("activities").innerHTML = '<div class="notice">Something went wrong during retrieval...</div>'
                  setTimeout(updateActivities, 5000)
              })
      }

      updateActivities();

      function updateProtopeners() {
          const timetable = document.getElementById("protopeners-timetable")
          const protopolisFa = document.getElementById('protopolis-fa')

          get('{{ route('api::screen::timetable::protopeners') }}')
              .then(data => {
                  if (data.length > 0) {
                      document.getElementById("protopeners-timetable").innerHTML = ''
                      let open = false, count = 0
                      data.forEach((protOpener) => {
                          if (protOpener.over||count>1) return

                          else if (protOpener.current) open = true
                          let start = moment.unix(protOpener.start);
                          let end = moment.unix(protOpener.end);
                          let time = start.format("HH:mm") + ' - ' + end.format("HH:mm");

                          let newDiv=document.createElement("div")
                          newDiv.className="activity "+(protOpener.current ? "current" : "")

                          let timeDiv=document.createElement("div")
                            timeDiv.className="float-start h-100"
                            timeDiv.innerHTML=time

                          let titleDiv=document.createElement("div")
                            titleDiv.className="float-end h-100"
                            titleDiv.innerHTML='<strong>'+protOpener.title+'</strong>'

                          newDiv.appendChild(timeDiv)
                          newDiv.appendChild(titleDiv)

                          let protOpenDiv=document.getElementById("protopeners-timetable")
                          protOpenDiv.appendChild(newDiv)
                          protOpenDiv.appendChild(document.createElement("br"))
                          protOpenDiv.appendChild(document.createElement("hr"))

                          count++
                      });
                      if (open) {
                          protopolisFa.classList.add('green')
                          protopolisFa.classList.replace('fa-door-closed', 'fa-door-open')
                      } else {
                          protopolisFa.classList.remove('green')
                          protopolisFa.classList.replace('fa-door-open', 'fa-door-closed')
                      }
                      if (count === 0) timetable.innerHTML = '<div class="notice">Protopolis closed for today!</div>'
                  } else {
                      timetable.innerHTML = '<div class="notice">Protopolis closed today!</div>'
                  }
                  setTimeout(updateProtopeners, 60000)
              })
              .catch(err => {
                  console.error(err)
                  timetable.innerHTML = '<div class="notice">Something went wrong during retrieval...</div>'
                  setTimeout(updateProtopeners, 5000)
              })
      }

      updateProtopeners()

      function updateClock(){
          document.getElementById('clock').innerHTML = moment().format('HH:mm:ss');
      }
      updateClock();
      setInterval(updateClock, 1000);

  </script>
</body>

</html>


