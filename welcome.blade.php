<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        @vite('resources/css/app.css')
        <!-- Styles -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body>
      <div id="content" class=""></div>
      <button id="loader" data-page="0" disabled="true" type="button" class="w-full text-center py-2.5 px-5 mr-2 text-sm font-medium text-gray-900 bg-white rounded border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
        <svg aria-hidden="true" role="status" class="inline mr-2 w-4 h-4 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"></path>
        </svg>
        Loading...
      </button>
      <div class="fixed right-0 top-0 text-xl bg-red-600 page p-2">
        1
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inview/1.0.0/jquery.inview.min.js" integrity="sha512-dy8Q+KMsxJmEgLqvZA7kk/Pcaij/OhCK1LPj+oGuxfd/tcbbqrDSGOtiXNfzKbMun+ZBnQsTWUnhuXhVkISDOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

      <script>
        

          let page = $("#loader");
  
          const options = {
            root: null,
            rootMargin: "20px",
            threshold: 1.0
          };
  
          const observer = new IntersectionObserver(async (entities) => {
            const target = entities[0];
    
            if (target.isIntersecting) {
              if($("#content").html() === "" && history.state.html) {
                $("#content").html(history.state.html)
                page.data("page", history.state.page)
                window.scrollTo(0, history.state.scroll)
                
              } else {
                $.ajax({
                  url: `http://localhost/caching/public/posts/${page.data("page")}`,
                  method: "GET",
                  
                }).done((res) => {
                    console.log("%c Searching Posts", "font-size: 22px; background-color: tomato; color: white; font-weight: bold")
                    res.forEach((value) => {
                      
                      $("#content").html($("#content").html() + `
                        <div class="p-1 max-w-xl rounded-xl group sm:flex space-x-6 bg-white bg-opacity-50 shadow-xl hover:rounded-2xl">
                          <img src="${value.image}" alt="art cover" loading="lazy" width="1000" height="667" class="h-56 sm:h-full w-full sm:w-5/12 object-cover object-top rounded-lg transition duration-500 group-hover:rounded-xl">
                          <div class="sm:w-7/12 pl-0 p-5">
                            <div class="space-y-2">
                                <div class="space-y-4">
                                <h4 class="text-2xl font-semibold text-cyan-900">${value.title}</h4>
                                <p class="text-gray-600">${value.body}</p>
                                </div>
                            </div>
                          </div>
                        </div>
                      `)
                    })

                    page.data("page", page.data("page") + 1)
                    history.replaceState({page: page.data("page"), html: $("#content").html()}, "")
                })
              }
                $(".page").text(page.data("page") + 1)
  
            }
          }, options);

          observer.observe(document.getElementById("loader"));
          
          document.addEventListener("scroll", (e) => {
            history.replaceState({...history.state, scroll: this.scrollY}, "")
          })
      </script>
    </body>
</html>
