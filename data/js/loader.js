$(document).ready(function () {
        const contentArea = $('#content');
            const router = () => {
                    const path = location.hash.substring(1) || 'home';
                            contentArea.html(`${path}`);
                                    loadContent(path);
                                        };
                                            const loadContent = async (page) => {
                                                    contentArea.html('<div class="text-center text-gray-500">Loading...</div>');

                                                            $.ajax({
                                                                        url: `/${page}?content_only`,
                                                                                    type: 'GET',
                                                                                                dataType: 'text',
                                                                                                            success: function (data) {
                                                                                                                            // Update the page content and title
                                                                                                                                            contentArea.html(`${data}`);

                                                                                                                                                        },
                                                                                                                                                                    error: function (jqXHR, textStatus, errorThrown) {
                                                                                                                                                                                    //console.error('Failed to load content:', textStatus, errorThrown);
                                                                                                                                                                                                    const errorMessage = `Page not found (${jqXHR.status})`;
                                                                                                                                                                                                                    contentArea.html(`<div id="app-content"><h1 class="text-4xl font-bold text-red-600">Error</h1><p class="text-lg text-gray-600">${errorMessage}. Please try again.</p></div>`);
                                                                                                                                                                                                                                    $(document).prop('title', 'Error');
                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                        });
                                                                                                                                                                                                                                                                $(window).on('hashchange', router);
                                                                                                                                                                                                                                                                        router();
                                                                                                                                                                                                                                                                            };
                                                                                                                                                                                                                                                                            });
})