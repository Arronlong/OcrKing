[General]
SyntaxVersion=2
MacroID=2811fb4a-9f42-41fc-80f3-022282e5706b
[Comment]

[Script]
//��������:��ױ
//QQ:394053565
//����type  ���������ԭʼurl��type���Ҵ�һ����ַ��type ����ܿ��ܾ��Ǵ��
//http://www.unknown.com  ��ֻ̨���г���Ԥ����
//http://www.nopreprocess.com  ��ֹ��̨���κ�Ԥ����
//http://user.56.com/api/get_auth.php?t=56_reg&rnd=0.5675823935307562 ��������֤��ַ��Ԥ����,���򱨴�
//����="eng"   Ӣ��=eng  ����=sim  ����=tra
//��֤������=7  ����Ӣ���ַ�=0 ���д�����=1 СдӢ����ĸ=2 ��дӢ����ĸ=3 ����Сд��ĸ=4 ���ִ�д��ĸ=5 ��дСд��ĸ=6 ���ִ�дСд=7 ����Ӣ���ַ�=8 ��ַ���ʼ���=9 $���̳Ǽ۸�=10 �ֻ��绰����=11 ��ѧ��ʽ����=12
//-----ʾ��----------
//key="�ʼ���ȡ��key"
//�ӿ�="http://lab.ocrking.com/ok.html"
//�� =OCRKING("C:/1.png",7,"eng",key,�ӿ�)
//��ʶ�����Ϊ��ѣ�Ψһ��ȡ KEY ��;��->��������  ���ʼ��� ok@ocrking.com ��ȡkey
//----------�ʼ���ʽ---------------------
//	�� key �� apiKey Ϊ�ʼ�����(2ѡ1����) 
//	�ʼ����� �������ݽ����ο����밴ʵ������޸�
//	��;���ĵ����ӻ����Զ���¼��ɨ��ά��.....
//	������PC��APP��WEB
//	���߻�����: eclipse,VS,ZS c++,c#,java,php,python,js .....
//	���ͣ����ˣ���˾����Դ�����
//	��Ⱥ������0-10,10-50,50-100,100+ .....
//---------------------------------------
//�鹹����򲻷���Ҫ��Ĳ���ظ�
//����˼������������������
//���ܻ����ӳ٣���Ҷ���ظ����ͣ�
//��η���ϵͳ���ܻ��ж�Ϊ�����ż�
//���ܻ����ӳ٣�����ظ�����
//��ȨapiKey,��ע�����ִ�Сд
//��վ��ҳ http://lab.ocrking.com/
//��վ��ҳ��QQ����Ⱥ,��ȡ����ģ��
Function OCRKING(·��,��֤������,����,key,�ӿ�)
    Dim xmlBody,BytesToBstr,strBoundary
    strBoundary=Class_Initialize()
    Call AddForm("service", "OcrKingForCaptcha",strBoundary)
    Call AddForm("language",����,strBoundary)
    Call AddForm("charset",��֤������,strBoundary)
    Call AddForm("type","http://www.nopreprocess.com",strBoundary)
    Call AddForm("apiKey",key,strBoundary)
    Call AddFile("ocrfile", "www.baidu.com", "image/jpg", ·��,strBoundary)
    xmlBody=Upload(�ӿ�,strBoundary)
    Set ObjStream = CreateObject("Adodb.Stream")
    With ObjStream
        .Type = 1
        .Mode = 3
        .Open
        .Write xmlBody
        .Position = 0
        .Type = 2
        .Charset = "utf-8"
        BytesToBstr = .ReadText
        .Close
    End With
    BytesToBstr=mid(BytesToBstr,instr(BytesToBstr,"<Result>")+len("<Result>"))
    BytesToBstr=left(BytesToBstr,instr(BytesToBstr,"<")-1)
    If InStr(BytesToBstr, "utf-8") > 0 Then 
        OCRKING=""
    Else
        OCRKING=BytesToBstr
    End If
End Function
Function StringToBytes(ByVal strData, ByVal strCharset)
    Dim objFile
    Set objFile = CreateObject("ADODB.Stream")
    objFile.Type = 2
    objFile.Charset = strCharset
    objFile.Open
    objFile.WriteText strData
    objFile.Position = 0
    objFile.Type = 1
    If UCase(strCharset) = "UNICODE" Then
        objFile.Position = 2
    ElseIf UCase(strCharset) = "UTF-8" Then
        objFile.Position = 3
    End If
    StringToBytes = objFile.Read(-1)
    objFile.Close
    Set objFile = Nothing
End Function
Function GetFileBinary(ByVal strPath)
    Dim objFile
    Set objFile = CreateObject("ADODB.Stream")
    objFile.Type = 1
    objFile.Open
    objFile.LoadFromFile strPath
    GetFileBinary = objFile.Read(-1)
    objFile.Close
    Set objFile = Nothing
End Function
Function GetBoundary()
    Dim ret(12)
    Dim table
    Dim i
    table = "abcdefghijklmnopqrstuvwxzy0123456789"
    Randomize
    For i = 0 To UBound(ret)
        ret(i) = Mid(table, Int(Rnd() * Len(table) + 1), 1)
    Next
    GetBoundary = "---------------------------" & Join(ret, Empty)
End Function
Sub AddForm(ByVal strName, ByVal strValue,ByVal strBoundary)
    Dim tmp
    tmp = "\r\n--$1\r\nContent-Disposition: form-data; name=""$2""\r\n\r\n$3"
    tmp = Replace(tmp, "\r\n", vbCrLf)
    tmp = Replace(tmp, "$1", strBoundary)
    tmp = Replace(tmp, "$2", strName)
    tmp = Replace(tmp, "$3", strValue)
    objTemp.Write StringToBytes(tmp, "UTF-8")
End Sub
Sub AddEnd(ByVal strBoundary)
    Dim tmp
    tmp = "\r\n--$1--\r\n" 
    tmp = Replace(tmp, "\r\n", vbCrLf) 
    tmp = Replace(tmp, "$1", strBoundary)
    objTemp.Write StringToBytes(tmp, "UTF-8")
    objTemp.Position = 2
End Sub
Function Upload(ByVal strURL,ByVal strBoundary)
    Call AddEnd(strBoundary)
    xmlHttp.Open "POST", strURL, False
    xmlHttp.setRequestHeader "Content-Type", "multipart/form-data; boundary=" & strBoundary
    xmlHttp.setRequestHeader "Content-Length", objTemp.size
    xmlHttp.setRequestHeader "Host", "lab.ocrking.com"
    xmlHttp.setRequestHeader "Expect", "100-continue"
    xmlHttp.Send objTemp
    Upload = xmlHttp.ResponseBody
End Function
Sub AddFile(ByVal strName, ByVal strFileName, ByVal strFileType, ByVal strFilePath,ByVal strBoundary)
    Dim tmp
    tmp = "\r\n--$1\r\nContent-Disposition: form-data; name=""$2""; filename=""$3""\r\nContent-Type: $4\r\n\r\n"
    tmp = Replace(tmp, "\r\n", vbCrLf)
    tmp = Replace(tmp, "$1", strBoundary)
    tmp = Replace(tmp, "$2", strName)
    tmp = Replace(tmp, "$3", strFileName)
    tmp = Replace(tmp, "$4", strFileType)
    objTemp.Write StringToBytes(tmp, "UTF-8")
    objTemp.Write GetFileBinary(strFilePath)
End Sub
Function Class_Initialize()
    Set xmlHttp = CreateObject("Msxml2.XMLHTTP")
    Set objTemp = CreateObject("ADODB.Stream")
    objTemp.Type =1
    objTemp.Open
    Class_Initialize=GetBoundary()
End Function

