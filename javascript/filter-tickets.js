document.addEventListener("DOMContentLoaded", function () {
     var searchButton = document.querySelector("#search-button");
     searchButton.addEventListener("click", performSearch);
   
     var searchBarInput = document.querySelector("#search-bar input");
     searchBarInput.addEventListener("keypress", function (event) {
       if (event.which === 13) {
         event.preventDefault();
         performSearch();
       }
     });
   
     function performSearch() {
      var filterDepartment = document.querySelector("select[name='department']").value;
      var filterAgent = document.querySelector("select[name='agent']").value;
      var filterPriority = document.querySelector("select[name='priority']").value;
      var filterStatus = document.querySelector("select[name='status']").value;
      var filterSort = document.querySelector("select[name='sort']").value;
      var filterSearch = document.querySelector("#search-bar input").value.toLowerCase();
    
      var ticketList = document.querySelector("#ticket-list");
      var tickets = ticketList.querySelectorAll("li");
    
      Array.from(tickets).forEach(function (ticket) {
        var department = ticket.querySelector(".department");
        var agent = ticket.querySelector(".agent");
        var priority = ticket.querySelector(".priority-box");
        var status = ticket.querySelector(".status");
        var title = ticket.querySelector("button");
        var tags = ticket.querySelector(".tags");
    
        var departmentText = department ? department.textContent.trim() : "";
        var agentText = agent ? agent.textContent.trim() : "";
        var priorityText = priority ? priority.textContent.trim() : "";
        var statusText = status ? status.textContent.trim() : "";
        var titleText = title ? title.textContent.trim().toLowerCase() : "";
        var tagsText = tags ? tags.textContent.trim().toLowerCase() : "";
    
        var showTicket =
          (filterDepartment === "" || departmentText === filterDepartment) &&
          (filterAgent === "" || agentText === filterAgent) &&
          (filterPriority === "" || priorityText === filterPriority) &&
          (filterStatus === "" || statusText === filterStatus) &&
          (!filterSearch || titleText.includes(filterSearch) || tagsText.includes(filterSearch));
    
        ticket.style.display = showTicket ? "block" : "none";
      });
    
      if (filterSort === "priority_asc") {
        var sortedTickets = Array.from(tickets).sort(function (a, b) {
          var priorityA = parseInt(a.querySelector(".priority-box").textContent);
          var priorityB = parseInt(b.querySelector(".priority-box").textContent);
          return priorityA - priorityB;
        });
        sortedTickets.forEach(function (ticket) {
          ticketList.appendChild(ticket);
        });
      } else if (filterSort === "priority_desc") {
        var sortedTickets = Array.from(tickets).sort(function (a, b) {
          var priorityA = parseInt(a.querySelector(".priority-box").textContent);
          var priorityB = parseInt(b.querySelector(".priority-box").textContent);
          return priorityB - priorityA;
        });
        sortedTickets.forEach(function (ticket) {
          ticketList.appendChild(ticket);
        });
      }
    }    
   });
   