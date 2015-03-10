+function() {
    var libraryApp = angular.module('libraryApp', ['ngResource', 'infinite-scroll']);

    /**
     * Некий фиктивный сервис авторизации
     */
    libraryApp.factory('AuthService', [function() {
        return 'secure_key';
    }]);

    libraryApp.factory('Author', ['$resource', 'AuthService', function($resource, Auth) {
        var authToken = Auth;
        return $resource('/app_dev.php/api/v1/authors/', {}, {
            query: {
                method: 'GET',
                params: {},
                isArray: true,
                headers: {
                    'X-Auth-Token': authToken
                }
            }
        });
    }]);

    libraryApp.controller('AuthorListCtrl', ['$scope', 'Author', function($scope, Author) {
        $scope.authors = [];
        $scope.page = 1;
        $scope.pagingEnabled = true;

        $scope.loadAuthors = function() {
            if($scope.pagingEnabled) {
                $scope.pagingEnabled = false;
                Author.query({page: $scope.page}, function(data) {

                    if(data.length > 0) {
                        angular.forEach(data, function(item) {
                            $scope.authors.push(item);
                        });
                        $scope.page++;
                        $scope.pagingEnabled = true;
                    }

                });
            }
        }
    }]);
}();