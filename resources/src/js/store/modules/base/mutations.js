export default {
    GET_DATA (state) {
        function capitalize(name) {
            return name.charAt(0).toUpperCase() + name.substr(1);
        }

        axios.get(`data`)
            .then(response => {
                state.courses = response.data["courses"];
                state.flashroster = response.data["students"];
                state.facultyMember.email = response.data["courses"][0].instructors[0].instructor;
                state.facultyMember.emailURI = state.facultyMember.email.replace("nr_", "").split('@')[0];
                state.facultyMember.profile = "http://www.csun.edu/faculty/profiles/" + state.facultyMember.name;
                state.facultyMember.firstName = capitalize(state.facultyMember.emailURI.split('.')[0]);
                state.facultyMember.lastName = capitalize(state.facultyMember.emailURI.split('.')[1]);

                axios.get(`faculty_profile/${response.data["courses"][0].instructors[0].instructor}`)
                    .then(response => {
                        state.facultyMember.image = response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            })
            .catch(e => {
                console.log(e);
            });
    },

    SET_LIST (state) {
        state.list = true;
    },

    SET_GRID (state) {
        state.list = false;
    },

    TOGGLE_FLASH (state) {
        state.flash = !state.flash;
    },

    TOGGLE_MENU (state) {
        state.menuShow = !state.menuShow;
    },

    SHUFFLE_FLASH (state) {
        function shuffle(students) {
            let currentIndex = students.length, temporaryValue, randomIndex;

            // While there remain elements to shuffle...
            while (0 !== currentIndex) {

                // Pick a remaining element...
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;

                // And swap it with the current element.
                temporaryValue = students[currentIndex];
                students[currentIndex] = students[randomIndex];
                students[randomIndex] = temporaryValue;
            }
        }

        let len = state.flashroster.length;

        for (let i = 0; i < len; ++i) {
            let unKnownStudents = [];
            let knownStudents = [];

            state.flashroster[i].forEach((student) => {
                if (student.recognized === true) {
                    knownStudents.push(student)
                } else {
                    unKnownStudents.push(student)
                }
            });

            shuffle(unKnownStudents);
            shuffle(knownStudents);

            state.flashroster[i] = unKnownStudents.concat(knownStudents);
        }

        state.flash = false;
        state.flash = true;
    },

    SORT_ROSTER: function (state) {
        let len = state.courses.length;
        for(let i = 0; i < len; ++i) {
            function sortedRoster (self) {
                if (state.sortLastName === true) {
                    if(state.sortDescending === true) {
                        return self.sort((a, b) => {
                            return a.last_name.localeCompare(b.last_name);
                        });
                    } else {
                        return self.sort((a, b) => {
                            return a.last_name.localeCompare(b.last_name);
                        }).reverse();
                    }
                } else {
                    if(state.sortDescending === true) {
                        return self.sort((a, b) => {
                            return a.first_name.localeCompare(b.first_name);
                        });
                    } else {
                        return self.sort((a, b) => {
                            return a.first_name.localeCompare(b.first_name);
                        }).reverse();
                    }
                }
            }

            state.courses[i].roster = sortedRoster(state.courses[i].roster);
        }
    },

    SORT_FIRST_NAME: function (state) {
        state.sortLastName = false;
    },

    SORT_LAST_NAME: function (state) {
        state.sortLastName = true;
    },

    SORT_DESC: function (state) {
        state.sortDescending = true;
    },

    SORT_ASC: function (state) {
        state.sortDescending = false;
    },
}
