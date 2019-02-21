const portfolioPostsBtn = document.getElementById("portfolio-posts-btn");
const portfolioPostsContainer = document.getElementById("portfolio-posts-container");

if (portfolioPostsBtn) {
    portfolioPostsBtn.addEventListener("click", () => {
        const ourRequest = new XMLHttpRequest();
        ourRequest.open('GET', myData.siteURL + "/wp-json/my-route/v1/search");
        ourRequest.onload = () => {
            if (ourRequest.status >= 200 && ourRequest.status < 400) {
                const data = JSON.parse(ourRequest.responseText);
                createHTML(data);
                portfolioPostsBtn.remove();
            } else {
                console.error("We connected to the server, but it returned an error")
            }
        };

        ourRequest.onerror = () => {
            console.error("Connection error");
        };

        ourRequest.send();
    });
}

function createHTML(postsData) {
    for (let i = 0; i < postsData.length; i++) {
        const div = document.createElement('div');
        const title = document.createElement('input');
        title.className = '';
        const input = document.createElement('input');
        title.value = postsData[i].post_title;
        input.value = postsData[i].post_content ? postsData[i].post_content.replace('\<p\>', '').replace('\<\/p\>', '') : postsData[i].post_content;
        let updateButton = document.createElement('button');
        updateButton.textContent = 'Update';
        (function (id) {
            updateButton.addEventListener('click', function () {
                const text = this.parentElement.childNodes[1].value;
                const title = this.parentElement.childNodes[0].value;
                const myRequest = new XMLHttpRequest();
                console.log(myData.siteURL);
                myRequest.open('POST', myData.siteURL + "/wp-json/my-route/v1/update");
                myRequest.setRequestHeader("X-WP-Nonce", myData.nonce);
                myRequest.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                myRequest.send(JSON.stringify({
                    id: id,
                    post_content: text,
                    post_title: title
                }));
                myRequest.onload = () => {
                    console.info('Success!')
                }
            });
        })(postsData[i].ID);
        div.appendChild(title);
        div.appendChild(input);
        div.appendChild(updateButton);
        portfolioPostsContainer.appendChild(div);
    }


}

// Delete Posts


//Add Posts

const addButton = document.querySelector("#quick-add-button");

// if (addButton) {
    addButton.addEventListener('click', () => {
        const ourPostData = {
            "title": document.querySelector('.admin-quick-add [name = "title"]').value,
            "content": document.querySelector('.admin-quick-add [name = "content"]').value,
            "status": "publish"
        };

        const createPost = new XMLHttpRequest();
        const url = 'http://localhost:8888/wordpress/wp-json/wp/v2/posts';
        createPost.open("POST", url);
        createPost.setRequestHeader("X-WP-Nonce", myData.nonce);
        createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        createPost.send(JSON.stringify(ourPostData));
        createPost.onload = () => {
            // console.log(createPost)
            // if (createPost.readyState === 4 && createPost.status === 201) {
                document.querySelector('.admin-quick-add [name = "title"]').value = '';
                document.querySelector('.admin-quick-add [name = "content"]').value = '';
            // }

        }
    })
// }