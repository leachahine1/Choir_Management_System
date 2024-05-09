from smith_waterman2 import alignment1_chars, alignment2_chars


def compare_note_groups(alignment1_chars, alignment2_chars):
    matches = []

    for index, (group1, group2) in enumerate(zip(alignment1_chars, alignment2_chars)):
        # Check if any note is None
        if group1 is None or group2 is None:
            matches.append(("No Match",))
        else:
            # Ensure that the lengths of the groups are the same
            if len(group1) != len(group2):
                matches.append(("Len. Mismatch",))
                continue
            else:
                # Check for pitch match
                if group1[1] == group2[1]:
                    pitch_match = "Pitch Match"
                else:
                    pitch_match = "Pitch Mismatch"

                # Check for duration match
                if abs(group1[2] - group2[2]) > 200:
                    duration_match = "Dur. Mismatch"
                else:
                    duration_match = "Dur. Match"

                matches.append((pitch_match, duration_match))

    return matches


# Example usage
matches = compare_note_groups(alignment1_chars, alignment2_chars)



# Print the matches
print("_______________")
print("matches", matches)


def sliding():
    sliding_list = []
    for i, s in enumerate(matches):
        if s[0] == 'Pitch Mismatch':
            if ((alignment1_chars[i+1][1]) == (alignment2_chars[i+1][1])) and ((alignment1_chars[i][1]) == (alignment2_chars[i+1][1])) and abs((alignment1_chars[i][1])-(alignment2_chars[i][1])) <= 2:
                sliding_list.append("Sliding")
            else:
                sliding_list.append(s)
        elif s == "Gap in seq2" or s == "Gap in seq1":
            if abs(int(ord(alignment2_chars[i]))-int(ord(alignment2_chars[i+1]))) <= 2:
                sliding_list.append("Sliding")
            else:
                sliding_list.append(s)
        else:
            sliding_list.append(s)
    print("sliding list:", sliding_list)

    return sliding_list

sliding_list = sliding()





