$('#userID').on('change', function (e) {
  e.preventDefault();

  var selectedUserID = $('#userID').val();
  if (selectedUserID == 'select_user') {
    $('#preDay').addClass('bg-light');
    $('#pre5').addClass('bg-light');
    $('#preCycle').addClass('bg-light');
    $('#prevDayCR').html('User not selected!');
    $('#prev5DayCR').html('User not selected!');
    $('#cycleCR').html('User not selected!');
  } else {
    $.ajax({
      type: 'POST',
      data: {
        userID: selectedUserID,
        teamID: 1,
      },
      url: 'call_rate.php',
      cache: false,
      success: function (response) {
        $('#kpi_cr').html(response);
        getReachClass(selectedUserID);
      },
    });
  }
});

function getReachClass(selectedUserID) {
  $.ajax({
    type: 'POST',
    dataType: 'JSON',
    data: {
      userID: selectedUserID,
      teamID: 1,
    },
    url: 'reach_class_percentage.php',
    cache: false,
    success: function (response) {
      // Reach Class
      let classArray = [];
      response['class'].forEach(function (items) {
        classArray.push(items);
      });

      let reachClassObject = {};
      for (var reachClass of classArray) {
        reachClassObject = reachClass;
      }
      
      $('#classReach').empty();
      for (var key in reachClassObject) {
        createEmptyDiv(key);
      }

      let classNameArray = [];
      let classValueArray = [];
      $('#classReach').hide().show(0);
      for (var key in reachClassObject) {
        addCircleProgress(reachClassObject[key] / 100, key);
        classNameArray.push(key);
        classValueArray.push(reachClassObject[key]);
      }
      //creating bar chart

      if (isCanvasBlank(document.getElementById('reachClassBarChart'))) {
        $('#reachClassBarChart').empty();
        barChart(classNameArray, classValueArray);
      } else {
        $('#reachClassBarChart').remove();
        $('#barCharDiv').append("<canvas id='reachClassBarChart'></canvas>");
        barChart(classNameArray, classValueArray);
      }

      //Class Frequency
      let freqClass = [];
      response['freq'].forEach(function (items) {
        freqClass.push(items);
      });

      let freqClassObject = {};
      for (var freq of freqClass) {
        freqClassObject = freq;
      }

      $('#freqClass').empty();
      var avg_freq = response['avg-freq'];
      for (const key in freqClassObject) {
        //change block color based on the avg freq value
        if (freqClassObject[key] >= avg_freq) {
          createNumberBlock(key, freqClassObject[key], 'bg-success');
        } else if (
          freqClassObject[key] >= avg_freq / 2 &&
          freqClassObject[key] < avg_freq
        ) {
          createNumberBlock(key, freqClassObject[key], 'bg-danger');
        } else if (freqClassObject[key] < avg_freq / 2) {
          createNumberBlock(key, freqClassObject[key], 'bg-warning');
        }
      }
    },
  });
}

function addCircleProgress(value, id) {
  let divID = document.getElementById(id);
  $(divID)
    .circleProgress({
      value: value,
      size: 150,
      fill: {
        gradient: ['red', 'orange'],
      },
    })
    .on('circle-animation-progress', function (event, progress, stopValue) {
      $(this)
        .parent()
        .find('strong')
        .text(String(stopValue.toFixed(2).substr(2)) + '%');
    });
}

function createEmptyDiv(id) {
  let outterDiv = document.createElement('div');
  outterDiv.style.cssText = 'margin: 20px;';

  let newDiv = document.createElement('div');
  newDiv.setAttribute('id', id);
  newDiv.style.cssText = 'position: relative;';

  let percentage = document.createElement('strong');
  percentage.style.cssText =
    'position: absolute; top: 50px; left: 0px; width: 100%; text-align: center; line-height: 40px; font-size: 30px;';

  let titleNode = document.createElement('span');
  let title = document.createTextNode(id);
  titleNode.style.cssText =
    'display: block; color: red; margin-top: 12px; margin-left: 45px;';

  titleNode.appendChild(title);

  newDiv.appendChild(percentage);
  newDiv.appendChild(titleNode);

  outterDiv.appendChild(newDiv);

  let currentDiv = document.getElementById('classReach');
  currentDiv.appendChild(outterDiv);
}

function createNumberBlock(key, value, color) {
  var outerMostDiv = document.createElement('div');
  outerMostDiv.className = 'col-lg-3 col-6';

  var outterDiv = document.createElement('div');
  outterDiv.className = 'small-box ' + color;

  outterDiv.setAttribute('id', 'freqClassBlock');

  var innerDiv = document.createElement('div');
  innerDiv.className = 'inner';

  var textValue = document.createElement('h3');
  var t = document.createTextNode(value);
  textValue.appendChild(t);

  var title = document.createElement('p');
  var subT = document.createTextNode(key);
  title.appendChild(subT);

  innerDiv.appendChild(textValue);
  innerDiv.appendChild(title);

  outterDiv.appendChild(innerDiv);

  outerMostDiv.appendChild(outterDiv);

  var currentDiv = document.getElementById('freqClass');

  currentDiv.insertBefore(outerMostDiv, null);
}
function barChart(label, datas) {
  const labels = label;
  const data = {
    labels: labels,
    datasets: [
      {
        backgroundColor: randomColor(datas.length),
        borderColor: 'rgb(60, 60, 60)',
        borderWidth: 1,
        barPercentage: 0.5,
        minBarLength: 2,
        data: datas,
      },
    ],
  };
  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      plugins: {
        title: {
          display: true,
          text: 'Class Reach Percentage 100%',
        },
        legend: {
          display: false,
        },
      },
    },
  };

  let myChart = new Chart(
    document.getElementById('reachClassBarChart'),
    config
  );
}

function randomColor(length) {
  var colors = [];
  while (colors.length < length) {
    do {
      var color = Math.floor(Math.random() * 1000000 + 1);
    } while (colors.indexOf(color) >= 0);
    colors.push('#' + ('000000' + color.toString(16)).slice(-6));
  }
  return colors;
}

// returns true if every pixel's uint32 representation is 0 (or "blank")
function isCanvasBlank(canvas) {
  const context = canvas.getContext('2d');

  const pixelBuffer = new Uint32Array(
    context.getImageData(0, 0, canvas.width, canvas.height).data.buffer
  );

  return !pixelBuffer.some((color) => color !== 0);
}
