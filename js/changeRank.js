// JavaScript Document
document.addEventListener("DOMContentLoaded", function () {
   var collapsibles = document.querySelectorAll(".collapsible");
   var overlay = document.querySelector("#episodeOverlay");
   collapsibles.forEach(function (div) {
      var rank = div.querySelector("select");
      var season = div.querySelector("#season_name").textContent;
      var user = overlay.querySelector("input[name='user']").value;
      
      rank.addEventListener("change", function() {
         updateRank(user, season, rank.value);
      });
   });
});

function updateRank(user, season, rank) {
   var data = {
      user: user,
      season: season,
      rank: rank
   };
   
   var xhr = new XMLHttpRequest();
   xhr.open('POST', '../php/tools/updateRank.php', true);
   xhr.setRequestHeader('Content-Type', 'application/json');
   xhr.send(JSON.stringify(data));
}