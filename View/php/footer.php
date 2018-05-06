        </div>
        <footer class="page-footer" id="contact">
            <div class="container">
                <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Footer Content</h5>
                    <ul>
                        <li><a class="email grey-text text-lighten-3 btn-flat waves-effect waves-purple col s12 left"><i class="fas fa-at"></i> brendanfreeman76@gmail.com</a></li>
                        <li><a class="grey-text text-lighten-3 btn-flat waves-effect waves-purple col s12" href="https://github.com/pepscrub/books"><i class="fab fa-github-alt"></i> Github Repo</a></li>
                        <li><a class="grey-text text-lighten-3 btn-flat waves-effect waves-red col s12" href="control/php/deletesessions.php"><i class="fas fa-server"></i> Delete Session</a></li>
                    </ul>
                    <p class="grey-text text-lighten-4">
                    </p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3 btn-flat waves-effect waves-light scrollspy" href="#books">Our Books</a></li>
                        <li><a class="grey-text text-lighten-3 btn-flat waves-effect waves-light scrollspy" href="#contact">Contact</a></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                © 2018 Brendan Freeman
                </div>
            </div>
            <script>
                // Clipboardjs email copy to clipboard
                var clipboard = new ClipboardJS('.email', {
                    text: function() {
                        return ' brendanfreeman76@gmail.com';
                    }
                });

                clipboard.on('success', function(e) {
                    M.toast({html: 'Copied to clipboard!'});
                });

                clipboard.on('error', function(e) {
                    console.log(e);
                });
            </script>
        </footer>
    </body>
</html>